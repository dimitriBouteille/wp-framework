<?php

namespace Dbout\Wp\Framework\Api\Route;

use Dbout\Wp\Framework\Api\Action\HttpDeleteRouteInterface;
use Dbout\Wp\Framework\Api\Action\HttpGetRouteInterface;
use Dbout\Wp\Framework\Api\Action\HttpPatchRouteInterface;
use Dbout\Wp\Framework\Api\Action\HttpPostRouteInterface;
use Dbout\Wp\Framework\Api\Action\HttpPutRouteInterface;
use Dbout\Wp\Framework\Api\Exception\HttpMethodNotSupported;
use Dbout\Wp\Framework\Api\Exception\RouteException;
use Dbout\Wp\Framework\Api\Exception\RouteNotImplementedException;
use App\Api\Helpers\Route;

/**
 * Class AbstractRoute
 * @package App\Api\Routes
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractRoute implements InterfaceRoute
{

    protected const MAPPING_METHODS = [
        'DELETE' => HttpDeleteRouteInterface::class,
        'GET' => HttpGetRouteInterface::class,
        'PATCH' => HttpPatchRouteInterface::class,
        'POST' => HttpPostRouteInterface::class,
        'PUT' => HttpPutRouteInterface::class,
    ];

    /**
     * @var string|null
     */
    protected ?string $namespace;

    /**
     * @var string|null
     */
    protected ?string $path;

    /**
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     * @throws \Exception
     */
    abstract protected function execute(\WP_REST_Request $request): \WP_REST_Response;

    /**
     * @return bool
     */
    public function canExecute(): bool
    {
        return true;
    }

    /**
     * Get arguments for this REST route.
     * @return array
     */
    protected function getArgs(): array
    {
        return [
            [
                // By default, all methods are supported
                'methods' => \WP_REST_Server::ALLMETHODS,
                'callback' => [$this, 'getResponse'],
                'permission_callback' => [$this, 'canExecute'],
                'args' => [],
            ],
        ];
    }

    /**
     * @param string $errorCode
     * @param string $errorMessage
     * @param int $httpStatusCode
     * @param bool $visibleFront
     * @param array $data
     * @return \WP_Error
     */
    protected function getErrorResponse(
        string $errorCode,
        string $errorMessage,
        int $httpStatusCode,
        bool $visibleFront = false,
        array $data = []
    ): \WP_Error {

        if (!$visibleFront) {
            // Default error
        }

        return new \WP_Error($errorCode, $errorMessage, array_merge($data, [
            'status' => $httpStatusCode,
        ]));
    }

    /**
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function getResponse(\WP_REST_Request $request): \WP_REST_Response
    {
        try {
            $methodInterface = self::MAPPING_METHODS[$request->get_method()] ?? null;
            if (!$methodInterface) {
                throw new RouteNotImplementedException();
            }

            if (!$this instanceof $methodInterface) {
                throw new HttpMethodNotSupported();
            }

            $response = $this->execute($request);
        } catch (RouteException $exception) {
            $response = $this->getErrorResponse(
                $exception->getErrorCode(),
                $exception->getMessage(),
                $exception->getCode(),
                $exception->isVisibleFront(),
                $exception->getAdditionalData()
            );
        } catch (\Exception $exception) {
            $response = $this->getErrorResponse(
                $exception->getCode(),
                $exception->getMessage(),
                500
            );
        }

        if (is_wp_error($response)) {
            $response = Route::parseWpErrorToRestResponse($response);
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route(
                $this->getNamespace(),
                $this->getPath(),
                $this->getArgs()
            );
        });
    }
}
