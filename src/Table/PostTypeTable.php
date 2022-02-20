<?php

namespace Dbout\Wp\Framework\Table;

use Dbout\WpHooks\Facade\Action;
use Dbout\WpHooks\Facade\Filter;

/**
 * Class PostTypeTable
 * @package Dbout\Wp\Framework\Table
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class PostTypeTable extends AbstractTable
{

    /**
     * @var string|null
     */
    protected ?string $primaryColumnSlug;

    /**
     * @inheritdoc
     */
    protected function init(): void
    {
        if (empty($this->primaryColumnSlug)) {
            _doing_it_wrong(__METHOD__, 'Primary Column Slug is required.', '5.0.0');
            return;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function runHooks(): void
    {
        Action::add('restrict_manage_posts', [$this, 'restrictManagePosts']);
        Action::add('manage_edit-'. $this->objectIdentifier.'_sortable_columns', [$this, 'defineSortableColumns']);

        Filter::add('list_table_primary_column', [$this, 'tablePrimaryColumn'], 10, 2);
        Filter::add('manage_' . $this->objectIdentifier . '_posts_columns', [$this, 'setupColumns']);
        Filter::add('bulk_actions-edit-' . $this->objectIdentifier, [$this, 'defineBulkActions']);
        Filter::add('manage_' . $this->objectIdentifier . '_posts_custom_column',[$this, 'renderColumns'], 10, 2);
        Filter::add('default_hidden_columns',[$this, 'defineDefaultHiddenColumns'], 10, 2);
        Filter::add('post_row_actions', [$this, 'rowActions'], 100, 2);
        Filter::add('request', [$this, 'requestQuery']);
    }

    /**
     * @param string $column
     * @param int $postId
     * @return void
     */
    public function renderColumns(string $column, int $postId): void
    {
        $this->_renderColumn($column, $postId);
    }

    /**
     * @param int $objectId
     * @param string $columnName
     * @return mixed
     */
    protected function loadRowData(int $objectId, string $columnName)
    {
        return get_post($objectId);
    }

    /**
     * Set row actions.
     * @param array $actions
     * @param \WP_Post $post
     * @return array
     */
    public function rowActions(array $actions, \WP_Post $post): array
    {
        if($this->objectIdentifier !== $post->post_type) {
            return $actions;
        }

        return $this->defineRowActions($actions, $post);
    }

    /**
     * Filters the name of the primary column for the current list table.
     * @param string $default
     * @param string $screenId
     * @return string
     */
    public function tablePrimaryColumn(string $default, string $screenId): string
    {
        if ($this->getEditScreenId() === $screenId && $this->primaryColumnSlug) {
            return $this->primaryColumnSlug;
        }

        return $default;
    }

    /**
     * Define bulk actions.
     * @param array $actions
     * @return array
     */
    public function defineBulkActions(array $actions): array
    {
        return $actions;
    }

    /**
     * @return void
     */
    public function restrictManagePosts()
    {
        if($this->isThis()) {
            $this->renderFilters();
        }
    }

    /**
     * Handle any filters
     * @param array $queryVars
     * @return array
     */
    public function requestQuery(array $queryVars): array
    {
        if($this->isThis()) {
            return $this->applyFilters($queryVars);
        }

        return $queryVars;
    }

    /**
     * Define hidden columns
     * @return array
     */
    public function defineDefaultHiddenColumns(): array
    {
        return [];
    }

    /**
     * Get row actions to show in the list table.
     * @param array $actions
     * @param \WP_Post $post
     * @return array
     */
    protected function defineRowActions(array $actions, \WP_Post $post): array
    {
        return $actions;
    }

    /**
     * Handle any custom filters
     * @param array $queryVars
     * @return array
     */
    protected function applyFilters(array $queryVars): array
    {
        return $queryVars;
    }

    /**
     * Render any custom filters and search inputs for the list table
     * @return void
     */
    protected function renderFilters(): void
    {
    }
}
