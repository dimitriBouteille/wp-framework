<?php

namespace Dbout\Wp\Framework\Gutenberg\Helper;

/**
 * Trait Asset
 * @package Dbout\Wp\Framework\Gutenberg\Helper
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
trait Schema
{

    /**
     * @param string|null $default
     * @return array
     */
    protected function getSchemaString(?string $default = ''): array
    {
        return [
            'type' => 'string',
            'default' => $default,
        ];
    }

    /**
     * @param int|null $default
     * @return array
     */
    protected function getSchemaNumber(?int $default): array
    {
        return [
            'type' => 'number',
            'default' => $default,
        ];
    }

    /**
     * @return array
     */
    protected function getSchemaListIds(): array
    {
        return [
            'type' => 'array',
            'default' => [],
            'items' => [
                'type' => 'number',
            ],
        ];
    }

    /**
     * @param bool $default
     * @return array
     */
    protected function getSchemaBoolean(bool $default = true): array
    {
        return [
            'type' => 'boolean',
            'default' => $default,
        ];
    }
}
