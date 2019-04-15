<?php

namespace Cb\RestFramework;

use Cb\RestFramework\Router\RouterFactory;

/**
 * Factory service to create an instance of Application
 * @package Cb\RestFramework
 */
class ApplicationFactory
{
    /**
     * @return Application
     */
    public function createService()
    {
        // TODO: RouterFactory should be loaded via service provider
        $routerFactory = new RouterFactory();
        $router = $routerFactory->createService();
        return new Application(
            $router,
            dirname(APP_BASE_PATH)
        );
    }
}
