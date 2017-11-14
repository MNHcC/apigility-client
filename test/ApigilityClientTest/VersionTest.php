<?php
namespace ApigilityClientTest;

use ApigilityClientTest\Framework\TestCase;

use MNHcC\ApigilityClient\Version;

class VersionTest extends TestCase
{
    public function testWillRetriveVersionNumber()
    {
        $this->assertEquals('0.2.0', Version::getVersion());
    }
}
