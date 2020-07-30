<?php
declare(strict_types=1);


namespace Core\Http;

/**
 * Class RequestFactory
 * @package Core\Http
 */
class RequestFactory
{
    /**
     * @param array|null $query
     * @param array|null $body
     * @param array|null $session
     * @param array|null $cookies
     * @param array|null $server
     * @return Request
     */
    public static function fromGlobals(
        array $query = null,
        array $body = null,
        array $session = null,
        array $cookies = null,
        array $server = null
    )
    {
        $request = new Request();
        $request->setQueryParams($query ?: $_GET);
        $request->setBody($body ?: $_POST);
        $request->setSession($session ?: (isset($_SESSION) ? $_SESSION : []));
        $request->setCookies($cookies ?: $_COOKIE);
        $request->setServer($server ?: $_SERVER);

        return $request;
    }
}