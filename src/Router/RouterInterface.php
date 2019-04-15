<?php

namespace Cb\RestFramework\Router;

use Cb\RestFramework\ApplicationInterface;

/**
 * Contract to handle HTTP request
 * @package Cb\RestFramework
 */
interface RouterInterface
{
    /**
     * Handler route HTTP request
     * @param ApplicationInterface $application
     * @return mixed
     */
    public function run(ApplicationInterface $application);
}
