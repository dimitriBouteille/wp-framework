<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class InputException
 * @package Dbout\Wp\Framework\Api\Exception
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class InputException extends RouteException
{

    protected bool $visibleFront = true;

    /**
     * @param string $error
     * @param array $additionalData
     */
    public function __construct(string $error, array $additionalData = [])
    {
        parent::__construct(
            $error,
            500,
            $additionalData
        );
    }
}