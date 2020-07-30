<?php
declare(strict_types=1);

namespace Core;

use Core\Http\Response;
use Core\Http\ResponseSender;

/**
 * Class ErrorHandler
 */
class ErrorHandler
{
    /**
     *
     */
    public function init()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        set_exception_handler([$this, 'handleException']);
    }

    /**
     * @param \Throwable $exception
     * @throws Exception
     */
    public function handleException(\Throwable $exception)
    {
        App::$logger->error($exception->getMessage());
        App::$logger->debug($exception->getTraceAsString());
        $view = new View();
        $html = $view->render('exception', ['exception' => $exception]);

        $response = new Response($html, 500);
        $responseSender = new ResponseSender();
        $responseSender->send($response);
        exit;
    }
}