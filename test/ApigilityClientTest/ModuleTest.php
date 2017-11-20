<?php
namespace ApigilityClientTest;

use ApigilityClientTest\Framework\TestCase;
use MNHcC\ApigilityClient\Module;
use Traversable;

class ModuleTest extends TestCase
{

    public function testGetAutoloaderConfig()
    {
        $module = new Module();
        $config = $module->getAutoloaderConfig();
        $this->assertFalse(!is_array($config) && !($config instanceof Traversable), 'getAutoloaderConfig expected to return array or Traversable');
    }

    public function testGetConfig()
    {
        $module = new Module();
        $config = $module->getConfig();
        $this->assertInternalType('array', $config);
    }

}
