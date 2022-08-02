<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class RouteNotImplementedException
 * @package App\Api\Exceptions
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RouteNotImplementedException extends RouteException
{

    /**
     * @var string
     */
    protected string $errorCode = 'route-not-implemented';

    /**
     * @param array $additionalData
     */
    public function __construct(array $additionalData = [])
    {
        parent::__construct(
            $this->errorCode,
            'Route not implemented.',
            500,
            $additionalData
        );
    }
}
