<?php

namespace Dbout\Wp\Framework\Router;

use Dbout\WpHooks\Facade\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Router
 * @package Dbout\Wp\Framework\Router
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Router
{

    /**
     * @var RouteCollection
     */
    protected RouteCollection $routeCollection;

    /**
     * @var self|null
     */
    protected static ?Router $instance = null;

    /**
     * @var UrlMatcher
     */
    protected UrlMatcher $urlMatcher;

    /**
     * @var RequestContext
     */
    protected RequestContext $requestContext;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routeCollection = new RouteCollection();
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest(Request::createFromGlobals());
        $this->requestContext->setBaseUrl('');
        $this->urlMatcher = new UrlMatcher($this->routeCollection, $this->requestContext);

        Action::add('init', [$this, 'matchCurrentRoute']);
        Action::add('wp_loaded', [$this, 'matchCurrentRoute']);
    }

    /**
     * @param string $routeName
     * @param Route $route
     */
    public static function add(string $routeName, Route $route): void
    {
        self::instance()->routeCollection->add($routeName, $route);
    }

    /**
     * @param string $routerName
     * @param array $params
     * @param int $referenceType
     * @return string|null
     */
    public static function generateUrl(
        string $routerName,
        array $params = [],
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_URL
    ): ?string {
        $generator = new UrlGenerator(self::instance()->routeCollection, self::instance()->requestContext);
        return $generator->generate($routerName, $params, $referenceType);
    }

    /**
     * @throws \ReflectionException
     */
    final public function matchCurrentRoute(): void
    {
        try {
            $match = $this->urlMatcher->match(rtrim($this->requestContext->getPathInfo(), '/'));
            if (is_array($match)) {
                $this->callController($match);
            }
        } catch (ResourceNotFoundException $exception) {
        }
    }

    /**
     * @param array $config
     * @throws \ReflectionException
     */
    protected function callController(array $config): void
    {
        $controllerClass = $config['_controller'];
        $action = $config['_action'] ?? 'index';
        $refClass = new \ReflectionClass($controllerClass);
        $ref = new \ReflectionMethod($controllerClass, $action);

        $constructorArgs = [];
        $constructor = $refClass->getConstructor();
        foreach ($constructor->getParameters() as $args) {
            if ($args->getType()->getName() === Request::class) {
                $constructorArgs[$args->getPosition()] = Request::createFromGlobals();
            }
        }

        $controller = new $controllerClass(...$constructorArgs);
        $controller->$action(...$this->buildArgsParameters($config, $ref->getParameters()));
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array $parameters
     * @param array $fncParameters
     * @return array
     */
    protected function buildArgsParameters(array $parameters, array $fncParameters): array
    {
        $args = [];
        foreach ($fncParameters as $parameter) {
            /** @var \ReflectionParameter $parameter */
            if (!isset($parameters[$parameter->getName()])) {
                continue;
            }

            $value = $parameters[$parameter->getName()];
            $args[$parameter->getPosition()] = $value;
        }

        return $args;
    }

}