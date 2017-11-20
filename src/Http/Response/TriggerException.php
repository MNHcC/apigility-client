<?php
namespace MNHcC\ApigilityClient\Http\Response;

use Zend\Http\Client as ZendHttpClient,
    Zend\Http\Response as ZendHttpResponse;

use MNHcC\ApigilityClient\Exception\RuntimeException;

class TriggerException
{

    /**
     * Throws an exception
     *
     * @param  Zend\Http\Client   $client
     * @param  Zend\Http\Response $response
     * @param  string|null        $message
     * @throws MNHcC\ApigilityClient\Exception\RuntimeException
     */
    public function __construct(ZendHttpClient $client, ZendHttpResponse $response, $message = null)
    {

        $error = $this->generateErrorObject($response);
        throw new RuntimeException(sprintf(
            'Erro "%s/%s". %s',
            $error->status,
            $error->title,
            $message ? $message.PHP_EOL.$error->detail : $error->detail 
        ), $error->status, null, $error);
    }
    
    protected function generateErrorObject($response) {
        $error = json_decode($response->getBody());
        if(!is_object($error)){
            $error = (object) [
                'status' => $response->getStatusCode(), 
                'title' => $response->getReasonPhrase(),
                'detail' => 'Non valid JSON answer.'.PHP_EOL.$response->getBody()
            ];
        }
        if(!property_exists($error, 'status')) {
            $error->status = $response->getStatusCode();
        } if(!property_exists($error, 'title')) {
            $error->title = $response->getReasonPhrase();
        } if(!property_exists($error, 'detail')) {
            $error->detail = 'Non valid HAL/JSON answer.'.PHP_EOL.$response->getBody();
        }
        return $error;
    }
}
