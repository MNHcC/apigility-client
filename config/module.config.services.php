<?php
namespace MNHcC\ApigilityClient;

return [
    'aliases' => [
        Http\Client::class => 'apigility.client',
    ],
    'factories' => [
        'apigility.client' => function ($sm) {
            $config = $sm->get('config');
            $clientConfig = $config['http_client'];

            $client = new \Zend\Http\Client($clientConfig['uri'], $clientConfig['options']);
            $client->getRequest()->getHeaders()->addHeaders($clientConfig['headers']);

            return new Http\Client($client);
        }
    ],
    'invokables' => [
    ],
    'shared' => [
        'apigility.client' => false,
    ],
];
