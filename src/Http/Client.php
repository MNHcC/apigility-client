<?php
namespace MNHcC\ApigilityClient\Http\Client;

use MNHcC\ApigilityClient\Exception\RuntimeException,
    MNHcC\ApigilityClient\Http\Response,
    MNHcC\ApigilityClient\Http\Client\ClientInterface;

use Zend\Http\Client as ZendHttpClient,
    Zend\Http\Client\Adapter\Curl,
    Zend\Http\Exception\RuntimeException as ZendHttpRuntimeException,
    Zend\Http\Request as ZendHttpRequest;

class Client implements ClientInterface
{

    /**
     * @const Int Timeout for each request
     */
    const TIMEOUT = 60;

    /**
     * @var Zend\Http\Client Instance
     */
    protected $zendClient;

    public function __construct(ZendHttpClient $client = null)
    {
        $client = ($client instanceof ZendHttpClient) ? $client : new ZendHttpClient();

        $this->setZendClient($client);
    }

    public function setZendClient(ZendHttpClient $client)
    {
        $this->zendClient = $client;

        return $this;
    }

    /**
     * Get the Zend\Http\Client instance
     *
     * @return Zend\Http\Client
     */
    public function getZendClient()
    {
        return $this->zendClient;
    }

    /**
     * Perform the request to api server
     *
     * @param String $path Example: "/v1/endpoint"
     * @param Array $headers
     */
    protected function doRequest($path, $headers = [])
    {
        $host = $this->getZendClient()->getUri()->getHost();

        if (empty($host)) {
            throw new ZendHttpRuntimeException(
                'Host not defined.'
            );
        }
        
        $this->getZendClient()->getUri()->setPath($path);

        $this->getZendClient()->getRequest()->getHeaders()->addHeaders($headers);

        $zendHttpResponse = $this->getZendClient()->send();

        try {
            $response = new Response($this->getZendClient(), $zendHttpResponse);
            $content = $response->getContent();
        } catch (ZendHttpRuntimeException $e) {
	    throw $e;
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function get($path, array $data = [], array $headers = [])
    {
        $this->getZendClient()->setMethod(ZendHttpRequest::METHOD_GET)
                         ->setParameterGet($data);

        return $this->doRequest($path, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $data, array $headers = [])
    {
        $this->getZendClient()->setMethod(ZendHttpRequest::METHOD_POST)
                         ->setRawBody(json_encode($data));

        return $this->doRequest($path, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $data, array $headers = [])
    {
        $this->getZendClient()->setMethod(ZendHttpRequest::METHOD_PUT)
                         ->setRawBody(json_encode($data));

        return $this->doRequest($path, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, array $data, array $headers = [])
    {
        $this->getZendClient()->setMethod(ZendHttpRequest::METHOD_PATCH)
                         ->setRawBody(json_encode($data));

        return $this->doRequest($path, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, array $headers = [])
    {
        $this->getZendClient()->setMethod(ZendHttpRequest::METHOD_DELETE);

        return $this->doRequest($path, $headers);
    }

    
}