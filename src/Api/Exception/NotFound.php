<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class NotFound
 * @package Dbout\Wp\Framework\Api\Exception
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class NotFound extends RouteException
{

    /**
     * @var bool
     */
    protected bool $visibleFront = true;

    /**
     * @param string|null $model
     * @param array $additionalData
     */
    public function __construct(
        ?string $model = null,
        array $additionalData = []
    ) {

        if (!$model) {
            $model = 'Object';
        }

        $message = printf(
            __( '%s not found.'),
            $model
        );

        parent::__construct(
            $message,
            404,
            $additionalData
        );
    }
}
