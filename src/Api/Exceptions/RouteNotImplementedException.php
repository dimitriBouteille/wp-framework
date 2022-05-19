<?php

namespace Dbout\Wp\Framework\Api\Exceptions;

/**
 * Class RouteNotImplementedException
 * @package Dbout\Wp\Framework\Api\Exceptions
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RouteNotImplementedException extends RouteException
{

    /**
     * @param array $additionalData
     */
    public function __construct(array $additionalData = [])
    {
        parent::__construct(
            'app_rest_invalid_endpoint',
            'Method not implemented',
            404,
            $additionalData
        );
    }
}
