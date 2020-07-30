<?php
declare(strict_types=1);


namespace Core\Http;


/**
 * Class ResponseSender
 * @package Core\Http
 */
class ResponseSender
{
    /**
     * @param Response $response
     */
    public function send(Response $response)
    {
        header(sprintf(
            'HTTP/%s %d %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
        foreach ($response->getHeaders() as $name => $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }

        echo $response->getBody();
    }
}