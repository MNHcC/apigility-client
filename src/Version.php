<?php
namespace MNHcC\ApigilityClient;

class Version
{

    /**
     * @var String
     */
    const VERSION = '0.2.2';

    /**
     * Get current version
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }
}
