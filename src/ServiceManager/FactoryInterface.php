<?php

namespace Cb\RestFramework\ServiceManager;

/**
 * Interface FactoryInterface
 */
interface FactoryInterface
{
    /**
     * Create a service
     * @return mixed
     */
    public function createService();
}
