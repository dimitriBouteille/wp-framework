<?php

namespace Dbout\Wp\Framework\Notice;

/**
 * Class NoticeRender
 * @package Dbout\Wp\Framework\Notice
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class NoticeRender
{

    /**
     * @var Notice
     */
    protected Notice $notice;

    /**
     * NoticeRender constructor.
     * @param Notice $notice
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Display notice
     */
    public function display(): void
    {
        $noticeFormat = '<div %1$s>%2$s</div>';
        $message = $this->aroundMessageWithParagraph($this->notice->getMessage());
        echo sprintf($noticeFormat, $this->getStringAttributes(), $message);
    }

    /**
     * @param string $message
     * @return string
     */
    protected function aroundMessageWithParagraph(string $message): string
    {
        if(preg_match("#^<(p|div)(.*)>#", $message, $m)) {
            return $message;
        }

        return sprintf('<p>%s</p>', $message);
    }

    /**
     * @return string
     */
    protected function getNoticeClass(): string
    {
        $classes = ['notice'];
        switch ($this->notice->getType()) {
            case Notice::TYPE_INFO:
                $classes[] = 'notice-info';
                break;
            case Notice::TYPE_WARNING:
                $classes[] = 'notice-warning';
                break;
            case Notice::TYPE_SUCCESS:
                $classes[] = 'notice-success';
                break;
            case Notice::TYPE_ERROR:
                $classes[] = 'notice-error';
                break;
        }

        if($this->notice->isDismissible()) {
            $classes[] = 'is-dismissible';
        }

        return implode(' ', $classes);
    }

    /**
     * @return string
     */
    protected function getStringAttributes(): string
    {
        $attributes[] = sprintf('class="%s"', $this->getNoticeClass());
        return implode(' ', $attributes);
    }
}
