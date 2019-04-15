<?php

namespace Cb\RestFramework;

/**
 * Wrapper service for $_SERVER super global variable
 * @package Cb\RestFramework
 */
class Server implements ServerInterface
{
    /** @var mixed[] */
    private $server;

    /**
     * Get super global variable $_SERVER
     * @return mixed[]
     */
    public function getServer()
    {
        if (empty($this->server)) {
            $this->server = $_SERVER;
        }
        
        return $this->server;
    }
}
