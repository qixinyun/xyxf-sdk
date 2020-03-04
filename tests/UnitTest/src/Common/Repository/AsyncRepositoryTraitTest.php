<?php
namespace Sdk\Common\Repository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Interfaces\IAsyncAdapter;

class AsyncRepositoryTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestAsyncRepository::class)
                    ->setMethods(['getAdapter'])->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testFetchOneAsync()
    {
        $id = 1;

        $adapter = $this->prophesize(IAsyncAdapter::class);
        $adapter->fetchOneAsync(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->fetchOneAsync($id);
        $this->assertTrue($result);
    }

    public function testFetchListAsync()
    {
        $ids = [1,2,3];

        $adapter = $this->prophesize(IAsyncAdapter::class);
        $adapter->fetchListAsync(Argument::exact($ids))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->fetchListAsync($ids);
        $this->assertTrue($result);
    }

    public function testSearchAsync()
    {
        $filter = array();
        $sort = array();
        $number = 1;
        $size = 10;

        $adapter = $this->prophesize(IAsyncAdapter::class);
        $adapter->searchAsync(
            Argument::exact($filter),
            Argument::exact($sort),
            Argument::exact($number),
            Argument::exact($size)
        )->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->searchAsync($filter, $sort, $number, $size);
        $this->assertTrue($result);
    }
}
