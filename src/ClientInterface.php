<?php
namespace MNHcC\ApigilityClient\Http\Client;

interface ClientInterface
{
    /**
     * Send a GET request
     *
     * @param String $path
     * @param Array $data
     *
     * @return Response
     */
    public function get($path, array $data = [], array $headers = []);

    /**
     * Send a POST request
     *
     * @param String $path
     * @param Array  $data
     *
     * @return Response
     */
    public function post($path, array $data, array $headers = []);

    /**
     * Send a PUT request
     *
     * @param String $path
     * @param Array  $data
     *
     * @return Response
     */
    public function put($path, array $data, array $headers = []);

    /**
     * Send a PATCH request
     *
     * @param String $path
     * @param Array  $data
     *
     * @return Response
     */
    public function patch($path, array $data, array $headers = []);

    /**
     * Send a DELETE request
     *
     * @param String $path
     *
     * @return Response
     */
    public function delete($path, array $headers = []);

}
