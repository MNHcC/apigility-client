<?php
namespace ApigilityClientTest\Http;

use ApigilityClientTest\Framework\TestCase;

use MNHcC\ApigilityClient\Http\Client as HttpClient,
    MNHcC\ApigilityClient\Http\Response;

use Zend\Http\Client as ZendHttpClient;

class ClientTest extends TestCase
{
    private $client;

    protected function setUp()
    {
        $zendHttpClient = new ZendHttpClient;
        $zendHttpClient->getUri()->setHost('api.localhost');

        $this->client = new HttpClient($zendHttpClient);
    }

    protected function tearDown()
    {
        $this->client = null;
    }

    /**
     * @expectedException Zend\Http\Exception\RuntimeException
     * @expectedExceptionMessage Host not defined.
     */
    public function testSetZendHttpClientThrowsAnException()
    {
        $this->client = new HttpClient();

        $this->client->setZendClient(new ZendHttpClient);
    }

    public function testGetZendHttpClient()
    {
        $this->assertInstanceOf('Zend\Http\Client', $this->client->getZendClient());
    }


}
