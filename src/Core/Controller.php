<?php
declare(strict_types=1);

namespace Core;


use Core\Http\Request;
use Core\Http\Response;

/**
 * Class Controller
 * @package Core
 */
class Controller
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $route
     * @return Response
     */
    public function redirect($route)
    {
        $response = new Response('', 301);
        $response->withHeader('Location', Router::createUrl($route));
        return $response;
    }
}