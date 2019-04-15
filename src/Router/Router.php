<?php

namespace Cb\RestFramework\Router;

use Cb\RestFramework\ApplicationInterface;
use Cb\RestFramework\Http\Request;
use Cb\RestFramework\ServerInterface;

/**
 * Service to handle HTTP request
 * @package Cb\RestFramework
 */
class Router implements RouterInterface
{
    const GET_METHOD = 'GET';
    const DELETE_METHOD = 'DELETE';
    const PUT_METHOD = 'PUT';
    const POST_METHOD = 'POST';

    const CONTROLLERS_NAMESPACE = 'Cb\Http\Controllers\\';
    const DEFAULT_ROUTE_MESSAGE = 'Route does not found or allowed';
    const HOME_ROUTE = '/';
    const HOME_RENDER_ACTION = 'HomeView';
    const VIEW_PATH = '/resources/views/';
    const HOME_VIEW = 'index.php';
    const ERROR_404 = '/errors/error404.php';

    /** @var ServerInterface */
    private $server;

    /** @var mixed[] */
    private $routes = [];

    /** @var ApplicationInterface */
    private $application;

    /**
     * @param ServerInterface $serverSuperGlobal
     */
    public function __construct(ServerInterface $serverSuperGlobal)
    {
        $this->server = $serverSuperGlobal;
        $this->addRoute(static::GET_METHOD, static::HOME_ROUTE, static::HOME_RENDER_ACTION);
    }

    /**
     * @inheritdoc
     */
    public function run(ApplicationInterface $application)
    {
        $uriWithParams = 3;
        $methodsUriParams = [static::GET_METHOD, static::DELETE_METHOD, static::PUT_METHOD];
        $this->application = $application;
        $server = $this->server->getServer();
        $uri = $server['REQUEST_URI'];
        $method = $server['REQUEST_METHOD'];

        /**
         * Note: This is a very basic way to get resource and resourceId from REST endpoint url styles
         * TODO: Implement a mechanism to get all possible parameters from URI
         */
        $uriData = explode('/', $uri);
        $resource = $uriData[1];
        $resourceId = null;
        if (count($uriData) > $uriWithParams) {
            $resourceId = $uriData[2];
        }
        
        if ($resourceId !== null && in_array($method, $methodsUriParams)) {
            $resource .= '/{id}';
        }

        $routeName = $method . '/' . $resource;

        /** @var mixed[] $route */
        $route = $this->routes[$routeName];
        if (empty($route)) {
            // Return 404 error page when requested route is not in routes directory
            $this->renderError404Page();
            return;
        }

        if (in_array($method, $methodsUriParams)) {
            // TODO: All parameters should be set in a dynamic way with dynamic names.
            $_GET['id'] = $resourceId;
        }

        $this->executeRouteAction($route);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param string $action
     */
    public function addRoute($method, $uri, $action)
    {
        $this->routes[$method . $uri] = ['method' => $method, 'uri' => $uri, 'action' => $action];
    }

    /**
     * @param mixed[] $route
     */
    private function executeRouteAction(array $route)
    {
        if ($route['action'] === static::HOME_RENDER_ACTION) {
            $this->renderHomeView();
            return;
        }

        list($controller, $action) = explode('@', $route['action']);
        $className = static::CONTROLLERS_NAMESPACE . $controller;
        $request = new Request();

        // TODO: this should be render by service manager
        $controller = new $className;
        $controller->{$action}($request);
    }

    /**
     * @return string
     */
    private function renderHomeView()
    {
        /**
         * Remember this is REST API this should not have any view render mechanism
         * this home view is just for documentation or code challenge purpose
         */
        return require_once $this->application->getBasePath() . static::VIEW_PATH . static::HOME_VIEW;
    }

    /**
     * @return string
     */
    private function renderError404Page()
    {
        /**
         * Remember this is REST API this should not have any view render mechanism
         * this 404 error page
         */
        return require_once $this->application->getBasePath() . static::VIEW_PATH . static::ERROR_404;
    }
}
