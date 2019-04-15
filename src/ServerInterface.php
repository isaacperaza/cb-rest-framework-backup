<?php

namespace Cb\RestFramework;

/**
 * Contract service for $_SERVER super global variable
 * @package Cb\RestFramework
 */
interface ServerInterface
{
    /**
     * Get super global variable $_SERVER
     * @return mixed[]
     */
    public function getServer();
}
