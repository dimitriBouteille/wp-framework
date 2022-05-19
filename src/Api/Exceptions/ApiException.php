<?php

namespace Dbout\Wp\Framework\Api\Exceptions;

/**
 * Class ApiException
 * @package Dbout\Wp\Framework\Api\Exceptions
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class ApiException extends \Exception
{

    /**
     * @var string
     */
    protected string $errorCode;

    /**
     * @var array
     */
    protected array $additionalData = [];

    /**
     * @param string $error_code       Machine-readable error code, e.g `app_invalid_product_id`.
     * @param string $message          User-friendly translated error message, e.g. 'Product ID is invalid'.
     * @param int    $http_status_code Proper HTTP status code to respond with, e.g. 400.
     * @param array  $additional_data  Extra data (key value pairs) to expose in the error response.
     */
    public function __construct($error_code, $message, $http_status_code = 400, array $additional_data = [])
    {
        $this->errorCode      = $error_code;
        $this->additionalData = array_filter((array) $additional_data);
        parent::__construct($message, $http_status_code);
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * @return array
     */
    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }
}
