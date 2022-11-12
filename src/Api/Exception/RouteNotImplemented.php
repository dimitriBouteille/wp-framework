<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class RouteNotImplementedException
 * @package App\Api\Exceptions
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RouteNotImplemented extends RouteException
{

    /**
     * @param array $additionalData
     */
    public function __construct(array $additionalData = [])
    {
        parent::__construct(
            'Route not implemented.',
            500,
            $additionalData
        );
    }
}
