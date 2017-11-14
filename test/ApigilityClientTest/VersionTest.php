<?php
namespace ApigilityClientTest;

use ApigilityClientTest\Framework\TestCase;

use MNHcC\ApigilityClient\Version;

class VersionTest extends TestCase
{
    public function testWillRetriveVersionNumber()
    {
        $this->assertEquals('0.3.5', Version::getVersion());
    }
}
