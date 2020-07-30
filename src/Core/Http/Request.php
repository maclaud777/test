<?php
declare(strict_types=1);

namespace Core\Http;

/**
 * Class Request
 * @package Core\Http
 */
class Request
{
    /**
     * @var array
     */
    private array $queryParams;

    /**
     * @var array
     */
    private array $body;

    /**
     * @var array
     */
    private array $session;

    /**
     * @var array
     */
    private array $cookies;

    /**
     * @var array
     */
    private array $server;

    /**
     * @param array $params
     */
    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }

    /**
     * @return array
     */
    public function getQueryParams() : array
    {
        return $this->queryParams;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body)
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getBody() : array
    {
        return $this->body;
    }

    /**
     * @param array $cookies
     */
    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * @return array
     */
    public function getCookies() : array
    {
        return $this->cookies;
    }

    /**
     * @param array $session
     */
    public function setSession(array $session)
    {
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getSession() : array
    {
        return $this->session;
    }

    /**
     * @param array $server
     */
    public function setServer(array $server)
    {
        $this->server = $server;
    }

    /**
     * @return array
     */
    public function getServer() : array
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getPathInfo()
    {
        $requestUri = $this->getServer()['REQUEST_URI'];
        $queryString = $this->getServer()['QUERY_STRING'];
        $scriptName = $this->getServer()['SCRIPT_NAME'];

        $path_info = str_replace('?' . $queryString, '', $requestUri);
        $path_info = str_replace($scriptName, '', $path_info);
        $path_info = trim($path_info, '/');

        return empty($path_info) ? '/' : $path_info;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return key_exists($key, $_REQUEST);
    }
}