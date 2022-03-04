<?php
namespace probe\Tests;

use PHPUnit_Framework_TestCase;
use Probe\ProviderFactory;

class ProviderFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testGetOsType()
    {
        $this->assertInternalType('string', ProviderFactory::getOsType());
    }

    public function testGetProvider()
    {
        $this->assertInstanceOf('\Probe\Provider\AbstractProvider', ProviderFactory::create());
    }
}
