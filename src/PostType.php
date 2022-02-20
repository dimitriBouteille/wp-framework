<?php

namespace Dbout\Wp\Framework;

/**
 * Class PostType
 * @package Dbout\Wp\Framework
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class PostType
{

    /**
     * Post type slug
     * @var string|null
     */
    protected ?string $slug;

    /**
     * Arguments for register_post_type function
     * https://codex.wordpress.org/Function_Reference/register_post_type
     * @var array
     */
    protected array $arguments = [
        'labels' => [],
        'public' => true,
        'show_in_rest' => false,
        'supports' => [],
    ];

    /**
     * WP_Post_Type after register
     * @var \WP_Post_Type|\WP_Error
     */
    protected $instance;

    /**
     * PostType constructor.
     * @param string $slug
     * @param string $singular
     * @param string $plural
     */
    public function __construct(string $slug, string $singular, string $plural)
    {
        $this->slug = $slug;
        $this->addLabels([
            'singular_name' => $singular,
            'name' => $plural,
        ]);
    }

    /**
     * @param array $labels
     * @return $this
     */
    public function addLabels(array $labels): self
    {
        $this->arguments['labels'] = array_merge($this->arguments['labels'], $labels);
        return $this;
    }

    /**
     * @param array $args
     * @return $this
     */
    public function addArguments(array $args): self
    {
        $this->arguments = array_merge($this->arguments, $args);
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function addArgument(string $name, $value): self
    {
        $this->arguments = array_merge($this->arguments, [$name => $value]);
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return \WP_Error|\WP_Post_Type
     */
    public function getWpInstance()
    {
        return $this->instance;
    }

    /**
     * Returns post type slug
     * @return string
     */
    public function __toString(): string
    {
        return $this->slug;
    }

    /**
     * Save the new post type in WP
     * @return $this
     */
    public function register(): self
    {
        $this->instance = register_post_type($this->slug, $this->arguments);
        return $this;
    }

    /**
     * Create new instance of PostType
     * @param string $slug
     * @param string $singularName
     * @param string $pluralName
     * @return static
     */
    public static function make(string $slug, string $singularName, string $pluralName): self
    {
        return new PostType($slug, $singularName, $pluralName);
    }
}
