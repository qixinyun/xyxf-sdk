<?php
namespace Sdk\Enterprise\Model;

use PHPUnit\Framework\TestCase;

class ContactsInfoTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new ContactsInfo(
            'weeks',
            '13201393874',
            '陕西省西安市雁塔区',
            '详细地址'
        );
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testGetName()
    {
        $this->assertEquals('weeks', $this->stub->getName());
    }

    public function testGetCellphone()
    {
        $this->assertEquals('13201393874', $this->stub->getCellphone());
    }

    public function testGetArea()
    {
        $this->assertEquals('陕西省西安市雁塔区', $this->stub->getArea());
    }

    public function testGetAddress()
    {
        $this->assertEquals('详细地址', $this->stub->getAddress());
    }
}
