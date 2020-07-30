<?php
declare(strict_types=1);


namespace Core\Http;

/**
 * Class Response
 * @package Core\Http
 */
class Response
{
    /**
     * @var array
     */
    private array $headers = [];
    /**
     * @var string
     */
    private string $body;
    /**
     * @var int
     */
    private int $statusCode;
    /**
     * @var string
     */
    private string $reasonPhrase = '';
    /**
     * @var string
     */
    private string $protocolVersion = '1.0';

    /**
     * @var array|string[]
     */
    private static array $phrases = [
        200 => 'OK',
        301 => 'Moved Permanently',
        303 => 'See Other',
        401 => 'Unauthorized',
        404 => 'Not Found',
        500 => 'Internal Server Error'
    ];

    /**
     * Response constructor.
     * @param string $body
     * @param int $status
     */
    public function __construct(string $body, $status = 200)
    {
        $this->body = $body;
        $this->statusCode = $status;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function withHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param $header
     * @return mixed|null
     */
    public function getHeader($header)
    {
        if (!$this->hasHeader($header)) {
            return null;
        }

        return $this->headers[$header];
    }

    /**
     * @param $header
     * @return bool
     */
    public function hasHeader($header)
    {
        return isset($this->headers[$header]);
    }

    /**
     * @param string $body
     */
    public function withBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param $code
     * @param string $reasonPhrase
     */
    public function withStatus($code, string $reasonPhrase = '')
    {
        $this->statusCode = $code;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        if (!$this->reasonPhrase && isset(self::$phrases[$this->statusCode])) {
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        }

        return $this->reasonPhrase;
    }

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }
}