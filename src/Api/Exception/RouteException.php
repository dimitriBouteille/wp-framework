<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class RouteException
 * @package App\Api\Exceptions
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RouteException extends \Exception
{

    /**
     * @var bool
     */
    protected bool $visibleFront = false;

    /**
     * @var string
     */
    protected string $errorCode;

    /**
     * @var array
     */
    protected array $additionalData = [];

    /**
     * @param string $errorCode
     * @param $message
     * @param $httpStatusCode
     * @param array $additionalData
     */
    public function __construct(
        string $errorCode,
        $message,
        $httpStatusCode = 400,
        array $additionalData = []
    ) {
        $this->errorCode = $errorCode;
        $this->additionalData = $additionalData;
        parent::__construct(
            $message,
            $httpStatusCode
        );
    }

    /**
     * @return bool
     */
    public function isVisibleFront(): bool
    {
        return $this->visibleFront;
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
