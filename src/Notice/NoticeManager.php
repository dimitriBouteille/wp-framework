<?php

namespace Dbout\Wp\Framework\Notice;

use Dbout\WpHooks\Facade\Action;

/**
 * Class NoticeManager
 * @package Dbout\Wp\Framework\Notice
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class NoticeManager
{

    /**
     * @var NoticeManager|null
     */
    protected static ?self $instance;

    /**
     * @var Notice[]
     */
    protected array $notices = [];

    /**
     * @param string $message
     * @param bool $dismissible
     */
    public function error(string $message, bool $dismissible = true): void
    {
        $this->notice(Notice::TYPE_ERROR, $message, $dismissible);
    }

    /**
     * @param string $message
     * @param bool $dismissible
     */
    public function success(string $message, bool $dismissible = true)
    {
        $this->notice(Notice::TYPE_SUCCESS, $message, $dismissible);
    }

    /**
     * @param string $message
     * @param bool $dismissible
     */
    public function warning(string $message, bool $dismissible = true): void
    {
        $this->notice(Notice::TYPE_WARNING, $message, $dismissible);
    }

    /**
     * @param string $message
     * @param bool $dismissible
     */
    public function info(string $message, bool $dismissible = true): void
    {
        $this->notice(Notice::TYPE_INFO, $message, $dismissible);
    }

    /**
     * @param string $type
     * @param string $message
     * @param bool $dismissible
     */
    public function notice(string $type, string $message, bool $dismissible = true)
    {
        $notice = new Notice();
        $notice->setType($type)
            ->setMessage($message)
            ->setDismissible($dismissible);

        $this->notices[] = $notice;
        $this->registerNotice($notice);
    }

    /**
     * @return NoticeManager
     */
    public static function getInstance(): self
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param Notice $notice
     */
    protected function registerNotice(Notice $notice): void
    {
        Action::add('admin_notices', [new NoticeRender($notice), 'display']);
    }
}