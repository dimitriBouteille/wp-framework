<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class HttpMethodNotSupported
 * @package App\Api\Exceptions
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class HttpMethodNotSupported extends RouteException
{

    protected string $errorCode = 'http-method-not-supported';

    /**
     * @param array $additionalData
     */
    public function __construct(array $additionalData = [])
    {
        parent::__construct(
            $this->errorCode,
            'Http method not supported.',
            500,
            $additionalData
        );
    }
}
