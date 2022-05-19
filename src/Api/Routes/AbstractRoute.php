<?php

namespace Dbout\Wp\Framework\Api\Routes;

use Dbout\Wp\Framework\Api\Exceptions\RouteException;
use Dbout\Wp\Framework\Api\Exceptions\RouteNotImplementedException;

/**
 * Class AbstractRoute
 * @package Dbout\Wp\Framework\Routes
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractRoute
{

    /**
     * @var string|null
     */
    protected ?string $namespace;

    /**
     * @var string|null
     */
    protected ?string $path;

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
     * Get arguments for this REST route.
     * @return array
     */
    public function getArgs(): array
    {
        return [
            [
                'methods' => \WP_REST_Server::ALLMETHODS,
                'callback' => [$this, 'getResponse'],
                'permission_callback' => '__return_true',
                'args' => [],
            ],
        ];
    }

    /**
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function getResponse(\WP_REST_Request $request): \WP_REST_Response
    {
        try {
            switch ($request->get_method()) {
                case \WP_REST_Server::CREATABLE:
                    $response = $this->getRoutePostResponse($request);
                    break;
                case \WP_REST_Server::DELETABLE:
                    $response = $this->getRouteDeleteResponse($request);
                    break;
                case \WP_REST_Server::READABLE:
                    $response = $this->getRouteGetResponse($request);
                    break;
                default:
                    throw new RouteNotImplementedException();
            }
        } catch (RouteException $exception) {
            $response = $this->getErrorResponse(
                $exception->getErrorCode(),
                $exception->getMessage(),
                $exception->getCode(),
                $exception->getAdditionalData()
            );
        } catch (\Exception $exception) {
            $response = $this->getErrorResponse($exception->getCode(), $exception->getMessage(), 500);
        }

        if (is_wp_error($response)) {
            $response = $this->parseToErrorRestResponse($response);
        }

        return $response;
    }

    /**
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     * @throws RouteNotImplementedException
     */
    protected function getRoutePostResponse(\WP_REST_Request $request): \WP_REST_Response
    {
        throw new RouteNotImplementedException();
    }

    /**
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     * @throws RouteNotImplementedException
     */
    protected function getRouteGetResponse(\WP_REST_Request $request): \WP_REST_Response
    {
        throw new RouteNotImplementedException();
    }

    /**
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     * @throws RouteNotImplementedException
     */
    protected function getRouteDeleteResponse(\WP_REST_Request $request): \WP_REST_Response
    {
        throw new RouteNotImplementedException();
    }

    /**
     * @param string $errorCode
     * @param string $errorMessage
     * @param int $httpStatusCode
     * @param array $data
     * @return \WP_Error
     */
    protected function getErrorResponse(
        string $errorCode,
        string $errorMessage,
        int $httpStatusCode,
        array $data = []
    ): \WP_Error {

        return new \WP_Error($errorCode, $errorMessage, array_merge($data, ['status' => $httpStatusCode]));
    }

    /**
     * @param \WP_Error $error
     * @return \WP_REST_Response
     */
    protected function parseToErrorRestResponse(\WP_Error $error): \WP_REST_Response
    {
        $errorData = $error->get_error_data();
        $status = $errorData['status'] ?? 500;
        $errors = [];

        foreach ((array) $error->errors as $code => $messages) {
            foreach ((array) $messages as $message) {
                $errors[] = array(
                    'code'    => $code,
                    'message' => $message,
                    'data'    => $error->get_error_data($code),
                );
            }
        }

        $data = array_shift($errors);
        if (count($errors)) {
            $data['additional_errors'] = $errors;
        }

        return new \WP_REST_Response($data, $status);
    }

    /**
     * @param \WP_REST_Response $response
     * @return array
     */
    protected function prepareResponseForCollection(\WP_REST_Response $response): array
    {
        $data = (array) $response->get_data();
        $server = rest_get_server();
        $links = $server::get_compact_response_links($response);
        if (!empty($links)) {
            $data['_links'] = $links;
        }

        return $data;
    }

    /**
     * @return void
     */
    public function register(): void
    {
        register_rest_route(
            $this->getNamespace(),
            $this->getPath(),
            $this->getArgs()
        );
    }
}
