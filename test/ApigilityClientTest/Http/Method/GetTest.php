<?php

namespace ApigilityClientTest\Http\Method;

use ApigilityClientTest\Framework\TestCase;

use MNHcC\ApigilityClient\Http\Client as HttpClient,
    MNHcC\ApigilityClient\Http\Response;

use Zend\Http\Client as ZendHttpClient,
    Zend\Http\Response as ZendHttpResponse;

class GetTest extends TestCase {

    /**
     *
     * @var HttpClient 
     */
    private $client;

    protected function setUp() {
        parent::setUp();
        // Mock JSON
        $json = <<< JSON
{
  "timestamp": 1385150462,
  "stuff": {
    "this": 2,
    "that": 4,
    "other": 1
    }
        
}
JSON;
        // Mock the client so it always returns the JSON we want    
        $mockResponse = $this->getMockBuilder(ZendHttpResponse::class)
            ->setMethods(['getContent'])
            ->getMock();
        $mockResponse->expects($this->any())
                ->method('getContent')
                ->will($this->returnValue($json));
        
        // Mock the client so that it always returns the pre-prepared response
        $zendHttpClient = $this->getMockBuilder(ZendHttpClient::class)
            ->setConstructorArgs(['http://api.localhost/', [] ])
            ->setMethods(['send'])
            ->getMock();
        $zendHttpClient->expects($this->any())
                ->method('send')
                ->will($this->returnValue($mockResponse));
        
        // The response will be the mock response created in the test
        //$zendHttpClient->getUri()->setHost();
        
        $this->client = new HttpClient($zendHttpClient);
    }

    public function testGet() {
        $this->assertInstanceOf(Response::class, $this->client->get('/foo/bar'));
    }
    
}
