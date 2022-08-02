<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class FrontRouteException
 * @package Dbout\Wp\Framework\Api\Exception
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class FrontRouteException extends RouteException
{

    /**
     * @param string $errorCode
     * @param $message
     * @param int $httpStatusCode
     * @param array $additionalData
     */
    public function __construct(
        string $errorCode,
        $message,
        int $httpStatusCode = 400,
        array $additionalData = []
    ) {
        parent::__construct(
            $errorCode,
            $message,
            $httpStatusCode,
            $additionalData
        );

        $this->visibleFront = true;
    }
}
