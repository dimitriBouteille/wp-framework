<?php

namespace Dbout\Wp\Framework;

use Dbout\WpHooks\Facade\Action;

/**
 * Class Page
 * @package Dbout\Wp\Framework
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Page
{

    /**
     * @var string
     */
    protected string $slug;

    /**
     * @var string
     */
    protected string $menuTitle;

    /**
     * @var string|null
     */
    protected ?string $pageTitle;

    /**
     * @var string|null
     */
    protected ?string $icon = '';

    /**
     * @var int|null
     */
    protected ?int $position;

    /**
     * @var string|null
     */
    private ?string $capability = 'manage_options';

    /**
     * Callback function to be called to output the content
     * @var array|null
     */
    protected ?array $callback = null;

    /**
     * @var null|string
     */
    protected ?string $subPage = null;

    /**
     * Page constructor.
     *
     * @param string $slug
     * @param string $menuTitle
     */
    private function __construct(string $slug, string $menuTitle)
    {
        $this->slug = $slug;
        $this->menuTitle = $menuTitle;
        $this->pageTitle = $menuTitle;
    }

    /**
     * Create new instance of Page
     *
     * @param string $slug
     * @param string $menuTitle
     * @return Page
     */
    public static function make(string $slug, string $menuTitle): Page
    {
        return new self($slug, $menuTitle);
    }

    /**
     * @param string $title
     * @return Page
     */
    public function setPageTitle(string $title): Page
    {
        $this->pageTitle = $title;
        return $this;
    }

    /**
     * @param string $icon
     * @return Page
     */
    public function setIcon(string $icon): Page
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string $pageId
     * @return Page
     */
    public function setShowInMenu(string $pageId): Page
    {
        $this->subPage = $pageId;
        return $this;
    }

    /**
     * @param int $position
     * @return Page
     */
    public function setPosition(int $position): Page
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @param array $callback
     * @return Page
     */
    public function setCallback(array $callback): Page
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getPageName(): ?string
    {
        return $this->pageTitle;
    }

    /**
     * Returns page slug
     * @return string
     */
    public function __toString(): string
    {
        return $this->getSlug();
    }

    /**
     * Save the new page in WP
     */
    public function register(): void
    {
        Action::add('admin_menu', function() {
            if(is_null($this->subPage)) {
                add_menu_page($this->pageTitle, $this->menuTitle, $this->capability, $this->slug, $this->callback, $this->icon, $this->position);
            } else {
                add_submenu_page($this->subPage, $this->pageTitle, $this->menuTitle, $this->capability, $this->slug, $this->callback);
            }
        });
    }
}