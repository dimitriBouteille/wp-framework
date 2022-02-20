<?php

namespace Dbout\Wp\Framework\Table;

use Dbout\WpHooks\Facade\Action;

/**
 * Class AbstractTable
 * @package Dbout\Wp\Framework\Table
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractTable
{

    /**
     * Post type or taxonomy name
     * @var string|null
     */
    protected ?string $objectIdentifier;

    /**
     * @var mixed
     */
    protected $currentRowData;

    public function __construct()
    {
        $this->init();
    }

    /**
     * @return void
     */
    protected function init(): void
    {
        if (empty($this->objectIdentifier)) {
            _doing_it_wrong(__METHOD__, 'Object identifier is required.', '5.0.0');
            return;
        }

        $callback = [$this, 'setupTable'];
        Action::add('current_screen', $callback);
        Action::add('check_ajax_referer', $callback);
    }

    /**
     * Register filters and actions
     *
     * @return void
     */
    public function setupTable(): void
    {
        if(function_exists('get_current_screen')) {
            $screen = \get_current_screen();
            if ($screen && isset($screen->id) && $screen->id === $this->getEditScreenId()) {
                $this->runHooks();
            }
        }

        /**
         * Ensure the table handler is only loaded once.
         * Prevents multiple loads if a plugin calls check_ajax_referer many times.
         */
        Action::remove('current_screen', [$this, 'setupTable']);
        Action::remove('check_ajax_referer', [$this, 'setupTable']);
    }

    /**
     * Define which columns to show on this screen.
     * @param array $columns
     * @return array
     */
    public function setupColumns(array $columns): array
    {
        return $this->defineColumns($columns);
    }

    /**
     * Define which columns are sortable
     * @param array $columns
     * @return array
     */
    public function defineSortableColumns(array $columns): array
    {
        return $columns;
    }

    /**
     * @param string $columnName
     * @param int $objectId
     * @return void
     */
    protected function _renderColumn(string $columnName, int $objectId): void
    {
        $this->currentRowData = $this->loadRowData($objectId, $columnName);
        $fncName = 'column';
        $fncName .= str_replace(' ', '', ucwords(str_replace('_', ' ', $columnName)));
        if(is_callable([$this, $fncName])) {
            $this->{$fncName}($this->currentRowData, $objectId);
        }
    }

    /**
     * @return string
     */
    protected function getEditScreenId(): string
    {
        return 'edit-'.$this->objectIdentifier;
    }

    /**
     * @return bool
     */
    protected function isThis(): bool
    {
        global $typenow;
        return $this->objectIdentifier === $typenow;
    }

    /**
     * @return void
     */
    protected abstract function runHooks(): void;

    /**
     * @param int $objectId
     * @param string $columnName
     * @return mixed
     */
    protected abstract function loadRowData(int $objectId, string $columnName);

    /**
     * @param array $columns
     * @return array
     */
    protected abstract function defineColumns(array $columns): array;
}
