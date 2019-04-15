<?php

namespace Cb\RestFramework\Http;

/**
 * Class Request
 * @package Cb\RestFramework\Http
 */
class Request
{
    /** @var mixed[] */
    private $request;

    /** @var mixed[] */
    private $params;

    /**
     * @return mixed[]
     */
    public function getRequest()
    {
        if (empty($this->request)) {
            $this->setRequest($_REQUEST);
        }
        
        return $this->request;
    }

    /**
     * @param mixed[] $request
     */
    public function setRequest(array $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        if (empty($this->params)) {
            $this->setParams($_GET);
        }

        return $this->params;
    }

    /**
     * @param array[] $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }
}
