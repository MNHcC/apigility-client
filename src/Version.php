<?php
namespace MNHcC\ApigilityClient;

class Version
{

    /**
     * @var String
     */
    const VERSION = '0.3.5';

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
