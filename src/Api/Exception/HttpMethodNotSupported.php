<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class HttpMethodNotSupported
 * @package Dbout\Wp\Framework\Api\Exception
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class HttpMethodNotSupported extends RouteException
{

    /**
     * @param array $additionalData
     */
    public function __construct(array $additionalData = [])
    {
        parent::__construct(
            'Http method not supported.',
            500,
            $additionalData
        );
    }
}
