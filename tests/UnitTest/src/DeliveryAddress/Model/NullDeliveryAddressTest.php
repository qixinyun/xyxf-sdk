<?php
namespace Sdk\DeliveryAddress\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullDeliveryAddressTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullDeliveryAddress::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsDeliveryAddress()
    {
        $this->assertInstanceof('Sdk\DeliveryAddress\Model\DeliveryAddress', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }

    public function tesSetDefault()
    {
        $result = $this->stub->setDefault();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }


    public function testDeletes()
    {
        $result = $this->stub->deletes();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
