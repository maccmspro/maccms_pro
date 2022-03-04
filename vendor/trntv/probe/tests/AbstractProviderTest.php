<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */

namespace Probe\Tests;

use Probe\ProviderFactory;

class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \probe\provider\AbstractProvider
     */
    protected $provider;

    public function setUp()
    {
        $this->provider = ProviderFactory::create();
    }

    public function testGetPhpVersion()
    {
        $this->assertEquals(phpversion(), $this->provider->getPhpVersion());
    }

    public function testGetPhpSapiName()
    {
        $this->assertEquals(php_sapi_name(), $this->provider->getPhpSapiName());
    }

    public function testBooleanResults()
    {
        $this->assertInternalType('boolean', $this->provider->isNginx());
        $this->assertInternalType('boolean', $this->provider->isApache());
        $this->assertInternalType('boolean', $this->provider->isISS());
        $this->assertInternalType('boolean', $this->provider->isBSDOs());
        $this->assertInternalType('boolean', $this->provider->isLinuxOs());
        $this->assertInternalType('boolean', $this->provider->isWindowsOs());
        $this->assertInternalType('boolean', $this->provider->isMacOs());
        $this->assertInternalType('boolean', $this->provider->isCli());
        $this->assertInternalType('boolean', $this->provider->isFpm());
    }

    public function testStringResults()
    {
        $this->assertInternalType('string', $this->provider->getOsRelease());
        $this->assertInternalType('string', $this->provider->getOsType());
        $this->assertInternalType('string', $this->provider->getOsKernelVersion());
        $this->assertInternalType('string', $this->provider->getArchitecture());
        $this->assertInternalType('string', $this->provider->getCpuModel());
        $this->assertInternalType('string', $this->provider->getCpuVendor());
        $this->assertInternalType('string', $this->provider->getPhpInfo());
    }

    public function testIntegerResults()
    {
        $this->assertInternalType('integer', $this->provider->getTotalMem());
        $this->assertGreaterThan(0, $this->provider->getTotalMem());
        $this->assertInternalType('integer', $this->provider->getFreeMem());
        $this->assertInternalType('integer', $this->provider->getUsedMem());
    }

    public function testGetUptime()
    {
        $this->assertInternalType('integer', $this->provider->getUptime());
        $this->assertGreaterThan(0, $this->provider->getUptime());
    }

    public function testNoException()
    {
        try {
            $this->provider->getCpuUsage();
        } catch (\Exception $notExpected) {
            $this->fail();
        }
        $this->assertTrue(true);
    }
}
