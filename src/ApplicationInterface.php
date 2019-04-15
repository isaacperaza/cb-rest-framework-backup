<?php

namespace Cb\RestFramework;

/**
 * Contract to execute the main Rest API application method
 */
interface ApplicationInterface
{
    /**
     * Execute main framework method
     */
    public function run();

    /**
     * Get Application base path
     * @return null|string
     */
    public function getBasePath();
}
