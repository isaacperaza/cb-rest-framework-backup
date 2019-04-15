<?php

namespace Cb\RestFramework\Exceptions;

use Cb\RestFramework\Http\HttpResponseCodes;
use Error;
use ErrorException;
use Exception;

/**
 * Application Error Hanlder
 * @package Cb\RestFramework\Exceptions
 */
trait ErrorHandler
{
    /**
     * Set the error handling for the application.
     *
     * @return void
     */
    protected function registerErrorHandling()
    {
        error_reporting(-1);

        set_error_handler(function ($level, $message, $file = '', $line = 0) {
            if (error_reporting() & $level) {
                throw new ErrorException($message, 0, $level, $file, $line);
            }
        });

        set_exception_handler(function ($e) {
            $this->handleUncaughtException($e);
        });

        register_shutdown_function(function () {
            $this->handleShutdown();
        });
    }

    /**
     * Handle the application shutdown routine.
     * @return void
     */
    protected function handleShutdown()
    {
        if (!is_null($error = error_get_last()) && $this->isFatalError($error['type'])) {
            // TODO: Implement shutdown problems
        }
    }

    /**
     * Determine if the error type is fatal.
     * @param int $type
     * @return bool
     */
    protected function isFatalError($type)
    {
        $errorCodes = [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE];

        if (defined('FATAL_ERROR')) {
            $errorCodes[] = FATAL_ERROR;
        }

        return in_array($type, $errorCodes);
    }

    /**
     * @param Exception | Error $error
     * @return void
     */
    protected function handleUncaughtException($error)
    {
        $code = $error->getCode();
        if (array_key_exists($code, HttpResponseCodes::$statusTexts) === false) {
            $code = HttpResponseCodes::HTTP_INTERNAL_SERVER_ERROR;
        }

        $codeText = HttpResponseCodes::$statusTexts[$code];
        $detail = $codeText;
        
        if (error_reporting() & E_ERROR) {
            $detail = $error->getMessage();
        }
        
        $response = [
            'error' => [
                'status' => $code,
                'detail' => $detail,
            ],
        ];

        header('HTTP/1.0 ' . $code . ' ' . $codeText);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
