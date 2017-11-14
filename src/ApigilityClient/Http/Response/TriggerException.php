<?php
namespace ApigilityClient\Http\Response;

use Zend\Http\Client as ZendHttpClient,
    Zend\Http\Response as ZendHttpResponse;

use ApigilityClient\Exception\RuntimeException;

class TriggerException
{

    /**
     * Throws an exception
     *
     * @param  Zend\Http\Client   $client
     * @param  Zend\Http\Response $response
     * @param  string|null        $message
     * @throws ApigilityClient\Exception\RuntimeException
     */
    public function __construct(ZendHttpClient $client, ZendHttpResponse $response, $message = null)
    {
        $error = json_decode($response->getBody());
        if(!is_object($error)){
            $error = (object) [
                'status' => $response->getStatusCode(), 
                'title' => $response->getReasonPhrase(),
                'detail' => 'Non valid answer. '.$response->getBody()
            ];
        }
        throw new RuntimeException(sprintf(
            'Erro "%s/%s". %s',
            $error->status,
            $error->title,
            $message ? $message.PHP_EOL.$error->detail : $error->detail 
        ));
    }
}
