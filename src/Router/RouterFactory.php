<?php

namespace Cb\RestFramework\Router;

use Cb\RestFramework\Server;
use Cb\RestFramework\ServerInterface;

class RouterFactory
{
    public function createService()
    {
        /** @var ServerInterface $serverSuperGlobal */
        $serverSuperGlobal = new Server();
        return new Router($serverSuperGlobal);
    }
}
