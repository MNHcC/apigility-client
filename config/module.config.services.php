<?php

namespace MNHcC\ApigilityClient;

return [
    'aliases' => [
        Http\Client::class => APIGILITY_CLIENT_SERVICE_NAME,
    ],
    'factories' => [
        APIGILITY_CLIENT_SERVICE_NAME => function ($sm) {
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
        APIGILITY_CLIENT_SERVICE_NAME => false,
    ],
];
