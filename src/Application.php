<?php

namespace Cb\RestFramework;

use Cb\RestFramework\Exceptions\ErrorHandler;
use Cb\RestFramework\Router\RouterInterface;

/**
 * Main REST API application class
 * @package Cb\RestFramework
 */
class Application implements ApplicationInterface
{
    use ErrorHandler;
    
    /** @var RouterInterface */
    private $router;
    
    /** @var null|string Application basePath */
    private $basePath;

    /**
     * Create a Resource Framework application instance.
     *
     * @param RouterInterface $router
     * @param string|null $basePath
     */
    public function __construct(
        RouterInterface $router,
        $basePath = null
    ) {
        $this->router = $router;
        $this->basePath = $basePath;
        $this->registerErrorHandling();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->router->run($this);
    }

    /**
     * @inheritdoc
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter()
    {
        return $this->router;
    }
}
