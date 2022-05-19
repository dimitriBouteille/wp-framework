<?php

namespace Dbout\Wp\Framework\Schemas;

/**
 * Class AbstractTermSchema
 * @package Dbout\Wp\Framework\Schemas
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractTermSchema extends AbstractSchema
{

    /**
     * @param \WP_Term $term
     * @return array
     */
    public function getItemResponse(\WP_Term $term): array
    {
        return [
            'id' => (int)$term->term_id,
            'name' => $term->name,
            'slug' => $term->slug,
            'description' => $term->description,
            'count' => $term->count,
            'parent' => $term->count,
            'url' => get_term_link($term),
        ];
    }
}
