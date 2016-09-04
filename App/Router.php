<?php

namespace App;
use App\Exception\RouteNotFoundException;

/**
 * Class Router
 *
 * @package App
 */
class Router
{
    const CONFIG_ROUTE_PATH = 'Src/Config/routing.xml';
    const CONFIG_CONTROLLER_PATH = '\\Src\\Controller\\';

    /**
     * @var \SimpleXMLElement
     */
    private $allRoutes;
    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var array
     */
    private $routeArgs;

    /**
     * @var string
     */
    private $controllerAction;

    /**
     * @param Request $request
     *
     * @throws \Exception
     */
    public function evalControllerAction(Request $request)
    {
        $routeContent = file_get_contents(dirname(__FILE__) . '/../' . self::CONFIG_ROUTE_PATH);

        if ($routeContent === false) {
            throw new RouteNotFoundException('Route config file not found', 404);
        }

        $this->allRoutes = new \SimpleXMLElement($routeContent);
        $mathRoute = false;

        foreach ($this->allRoutes->route as $route) {
            if ($this->matchRoute($route, $request)) {
                $mathRoute = true;
                $this->storeRouteInfo($route, $request);
            }
        }

        if (!$mathRoute) {
            throw new RouteNotFoundException('The request doesn\'t match any route');
        }
    }

    /**
     * @return ControllerInterface
     */
    public function getController()
    {
        $controllerPath = self::CONFIG_CONTROLLER_PATH . $this->controllerName;

        try {
            $controller = new $controllerPath();
        } catch (\Exception $e) {
            throw new \Exception('No controller found', 500);
        }

        return $controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->controllerAction;
    }

    /**
     * @param \SimpleXMLElement $route
     * @param Request $request
     *
     * @return bool
     */
    private function matchRoute(\SimpleXMLElement $route, Request $request)
    {
        if ($request->getMethod() === (string) $route->method
            && $this->matchScheme($route->scheme, $request)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $scheme
     * @param Request $request
     *
     * @return bool
     */
    private function matchScheme($scheme, Request $request)
    {
        $requestScheme = explode('/', $request->getUri());
        $routeScheme = explode('/', (string) $scheme);
        $this->routeArgs = array();

        if (count($requestScheme) !== count($routeScheme)) {
            return false;
        }

        foreach ($routeScheme as $key => $val) {
            if (!isset($requestScheme[$key]) ||
                ($val !== $requestScheme[$key] &&
                    (strpos($val, '{') === false && strpos($val, '}') === false))) {
                return false;
            } else if (strpos($val, '{') !== false && strpos($val, '}') !== false) {
                $arg = trim($val, '{}');
                $this->routeArgs[$arg] = $requestScheme[$key];
            }
        }

        return true;
    }

    /**
     * @param \SimpleXMLElement $route
     */
    private function storeRouteInfo(\SimpleXMLElement $route, Request $request)
    {
        $this->controllerName = (string) $route->controller;
        $this->controllerAction = (string) $route->action;
        $request->setData($this->routeArgs);
    }
}