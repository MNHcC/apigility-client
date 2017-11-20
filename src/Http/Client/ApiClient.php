<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\ApigilityClient\Http\Client;

use Zend\Http\Client as ZendHttpClient,
    Zend\Http\Client\Adapter\Curl,
    Zend\Http\Exception\RuntimeException as ZendHttpRuntimeException,
    Zend\Http\Request as ZendHttpRequest;

use MNHcC\ApigilityClient\Exception\InvalidArgumentException,
    MNHcC\ApigilityClient\Http\Client\Client;

/**
 * 
 * @todo add description to IdClient
 * @author Michael Hegenbarth <mnh@mn-hegenbarth.de>
 */
class ApiClient {

    /**
     *
     * @var string 
     */
    protected $defaultPath = '';
    
    /**
     *
     * @var bool 
     */
    protected $usePattern = false;

    /**
     *
     * @var Client 
     */
    protected $client = null;
    
    public function __construct(Client $client = null, $defaultPath = null) {
        $this->setClient($client)
        ->setDefaultPath($defaultPath);
        
    }
    /**
     * Get throw exceptions
     *
     * @return boolean
     */
    public function getThrowExceptions()
    {
        return $this->throwExceptions;
    }
    /**
     * Set throw exceptions
     *
     * @param boolean $throwExceptions
     */
    public function setThrowExceptions($throwExceptions)
    {
        $this->throwExceptions = $throwExceptions;
    }
    /**
     * Create
     *
     * @param string $apiPath (optional) 
     * @param array $data
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function create($apiPath = null, array $data = null)
    {
        if(is_array($apiPath)){
            $data = $apiPath;
            $apiPath = null;
        } elseif(!is_array($data)) {
            throw InvalidArgumentException(sprintf('%s() require a data array', __METHOD__));
        }
        return $this->getClient()->post($this->normalizeUri($apiPath), $data);
    }
    
    /**
     * Delete
     * 
     * @param string $apiPath (optional) the path (uri) to the api you can set to null for using the object property 
     * @param int|string $id the id for the api resurce
     * @param array $queryData the get parameters
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function delete($apiPath, $id = null, array $queryData = [])
    {
        if(is_array($id)){
            $queryData = $id;
            $id = $apiPath;
            $apiPath = null;
        }
        if(empty($id) && $id !== 0)
            throw new InvalidArgumentException(sprintf('%s() require a valid and not empty id', __METHOD__));
        
        $this->getClient()->getZendClient()->setParameterGet($queryData);
        return $this->getClient()->delete($this->normalizeUri($apiPath, $id));
    }
    
    /**
     * 
     * @param string $apiPath (optional) the path (uri) to the api you can set to null for using the object property 
     * @param int|string $id the id for the api resurce
     * @param array $data the list
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function deleteList($apiPath = null, array $data = [])
    {
        if(is_array($apiPath)){
            $data = $apiPath;
            $apiPath = null;
        }
        return $this->getClient()->delete($this->normalizeUri($apiPath), $data);
    }
    
    /**
     * Fetch on api
     * @param string $apiPath (optional) 
     * @param int|string $id the id for the api resurce
     * @param array $data (optional)
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function fetch($apiPath, $id = null, array $data = [])
    {
        if(is_array($id)){
            $data = $id;
            $id = $apiPath;
            $apiPath = null;
        }
        if(empty($id) && $id !== 0)
            throw new InvalidArgumentException(sprintf('%s() require a valid and not empty id', __METHOD__));
        
        return $this->getClient()->get($this->normalizeUri($apiPath, $id), $data);
    }
    
    /**
     * Fetch all
     *
     * @param string $apiPath
     * @param array $queryData
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function fetchAll($apiPath = null, array $queryData = [])
    {
        if(is_array($apiPath)){
            $data = $apiPath;
            $apiPath = null;
        }
        return $this->getClient()->get($apiPath, $queryData);
    }
    
    /**
     * Patch
     *
     * @param string $apiPath
     * @param int|string $id
     * @param array $data
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function patch($apiPath, $id, array $data = [])
    {
        return $this->getClient()->patch($this->normalizeUri($apiPath, $id), $data);
    }
    
    /**
     * Update
     *
     * @param string $apiPath
     * @param int|string $id
     * @param array $data
     * @rerturn \MNHcC\ApigilityClient\Http\Response
     */
    public function update($apiPath, $id, array $data = [])
    {
        return $this->getClient()->put($this->normalizeUri($apiPath, $id), $data);
    }

    
    /**
     * Check if exception should be thrown
     * @param object $response
     * @return object
     * @throws ClientException
     */
    private function checkException($response)
    {
        if ((true === $this->getThrowExceptions()) and ($this->isErroneousResponse($response))) {
            throw new ClientException($response->detail, $response->status);
        }
        return $response;
    }

    
    function getDefaultPath() {
        return $this->defaultPath;
    }

    function getUsePattern() {
        return $this->usePattern;
    }

    function setDefaultPath($defaultPath) {
        $this->defaultPath = $defaultPath;
    }

    function setUsePattern($usePattern) {
        $this->usePattern = $usePattern;
    }
    
    /**
     * Normalize uri
     *
     * @param string $apiPathPath
     * @param string|int $id the id for resurce
     * @return string
     */
    protected function normalizeUri($apiPathPath = null, $id = null)
    {
        $apiPathPath = $apiPathPath || $this->getDefaultPath();
        if (!$this->getUsePattern()) {
            if (null === $id) {
                return '/' . ltrim($apiPathPath, '/');
            } else {
                return '/' . trim($apiPathPath, '/') . '/' . $id;
            }
        } else {
            return sprintf($apiPathPath, $id ? '/' . trim($id, '/') : '');
        }
    }
    
    public function __call($name, $arguments) {

    }
    
    /**
     * 
     * @return Client
     */
    function getClient() {
        return $this->client;
    }

    /**
     * 
     * @param Client $client
     * @return $this
     */
    function setClient(Client $client) {
        $this->client = $client;
        return $this;
    }


    
}
