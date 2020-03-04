<?php
namespace Sdk\Common\Adapter;

use PHPUnit\Framework\TestCase;

class AsyncFetchAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestAsyncFetchAbleRestfulAdapter::class)
                    ->setMethods(['getAsync',])->getMock();

        $this->childStub = new class extends TestAsyncFetchAbleRestfulAdapter
        {
            public function fetchOneAsyncAction(int $id)
            {
                return parent::fetchOneAsyncAction($id);
            }

            public function fetchListAsyncAction(array $ids)
            {
                return parent::fetchListAsyncAction($ids);
            }

            public function searchAsyncAction(
                array $filter = array(),
                array $sort = array(),
                int $number = 0,
                int $size = 20
            ) {
                return parent::searchAsyncAction($filter, $sort, $number, $size);
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testFetchOneAsync()
    {
        $this->stub = $this->getMockBuilder(TestAsyncFetchAbleRestfulAdapter::class)
                    ->setMethods(['fetchOneAsyncAction'])->getMock();

        $id = 1;
        $array = [1,2];

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAsyncAction')
            ->with($id)
            ->willReturn($array);

        $result = $this->stub->fetchOneAsync($id);
        $this->assertEquals($array, $result);
    }

    public function testFetchOneAsyncAction()
    {
        $id = 1;
        $array = [1,2];

        $this->stub->expects($this->exactly(1))
            ->method('getAsync')
            ->with('member/'.$id)
            ->willReturn($array);

        $result = $this->stub->fetchOneAsync($id);
        $this->assertEquals($array, $result);
    }

    public function testFetchListAsync()
    {
        $this->stub = $this->getMockBuilder(TestAsyncFetchAbleRestfulAdapter::class)
            ->setMethods(
                [
                    'fetchListAsyncAction'
                ]
            )->getMock();
        $ids = array(1,2,3);
        $array = [1,2];

        $this->stub->expects($this->exactly(1))
            ->method('fetchListAsyncAction')
            ->with($ids)
            ->willReturn($array);

        $result = $this->stub->fetchListAsync($ids);
        $this->assertEquals($array, $result);
    }

    public function testFetchListAsyncAction()
    {
        $ids = array(1,2,3);
        $array = [1,2];

        $this->stub->expects($this->exactly(1))
            ->method('getAsync')
            ->with('member/'.implode(',', $ids))
            ->willReturn($array);

        $result = $this->stub->fetchListAsync($ids);
        $this->assertEquals($array, $result);
    }

    public function testSearchAsync()
    {
        $this->stub = $this->getMockBuilder(TestAsyncFetchAbleRestfulAdapter::class)
            ->setMethods(
                [
                    'searchAsyncAction'
                ]
            )->getMock();
        $filter = array();
        $sort = ['-updateTime'];
        $page = 1;
        $size = 10;
        $array = [1,2];

        $this->stub->expects($this->exactly(1))
            ->method('searchAsyncAction')
            ->with($filter, $sort, $page, $size)
            ->willReturn($array);

        $result = $this->stub->searchAsync($filter, $sort, $page, $size);
        $this->assertEquals($array, $result);
    }

    public function testSearchAsyncAction()
    {
        $filter = array();
        $sort = ['-updateTime'];
        $page = 1;
        $size = 10;
        $array = [1,2];

        $this->stub->expects($this->exactly(1))
            ->method('getAsync')
            ->with('member')
            ->willReturn($array);

        $result = $this->stub->searchAsync($filter, $sort, $page, $size);
        $this->assertEquals($array, $result);
    }
}
