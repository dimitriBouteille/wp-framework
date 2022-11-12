<?php

namespace Dbout\Wp\Framework\Api\Exception;

/**
 * Class RouteException
 * @package Dbout\Wp\Framework\Api\Exception
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
     * @var string|null
     */
    protected ?string $errorCode;

    /**
     * @var array
     */
    protected array $additionalData = [];

    /**
     * @param $message
     * @param int $httpStatusCode
     * @param array $additionalData
     * @param string|null $errorCode
     */
    public function __construct(
        $message,
        int $httpStatusCode = 400,
        array $additionalData = [],
        string $errorCode = null
    ) {

        // Auto format Error based on classname
        if (!$errorCode) {
            $path = explode('\\', __CLASS__);
            $errorCode = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', array_pop($path)));
        }

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
