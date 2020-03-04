<?php
namespace Sdk\Common\Adapter;

use PHPUnit\Framework\TestCase;

use Sdk\Member\Utils\MockFactory;

class FetchAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestFetchAbleRestfulAdapter::class)
            ->setMethods(
                [
                    'get',
                    'translateToObjects',
                    'isSuccess',
                ]
            )->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testFetchListSuccess()
    {
        $ids = array(1,2,3);
        $member = array(
            MockFactory::generateMemberObject(1),
            MockFactory::generateMemberObject(2),
            MockFactory::generateMemberObject(3),
            );

        $memberArray = array(
            MockFactory::generateMemberArray(1),
            MockFactory::generateMemberArray(2),
            MockFactory::generateMemberArray(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('member/'.implode(',', $ids))
            ->willReturn($memberArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('translateToObjects')
            ->willReturn($member);

        $result = $this->stub->fetchList($ids);
        $this->assertEquals($member, $result);
    }

    public function testFetchListActionFailure()
    {
        $ids = array(1,2,3);

        $memberArray = array(
            MockFactory::generateMemberArray(1),
            MockFactory::generateMemberArray(2),
            MockFactory::generateMemberArray(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('member/'.implode(',', $ids))
            ->willReturn($memberArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);

        $this->stub->expects($this->exactly(0))
            ->method('translateToObjects');

        $result = $this->stub->fetchList($ids);
        $this->assertEquals(array(0, array()), $result);
    }

    public function testSearchSuccess()
    {
        $filter = array();
        $sort = array();
        $page = 0;
        $size = 10;
        
        $member = array(
            MockFactory::generateMemberObject(1),
            MockFactory::generateMemberObject(2),
            MockFactory::generateMemberObject(3),
        );

        $memberArray = array(
            MockFactory::generateMemberArray(1),
            MockFactory::generateMemberArray(2),
            MockFactory::generateMemberArray(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('member')
            ->willReturn($memberArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('translateToObjects')
            ->willReturn($member);

        $result = $this->stub->search($filter, $sort, $page, $size);
        $this->assertEquals($member, $result);
    }

    public function testSearchActionFailure()
    {
        $filter = array();
        $sort = array();
        $page = 0;
        $size = 10;

        $memberArray = array(
            MockFactory::generateMemberArray(1),
            MockFactory::generateMemberArray(2),
            MockFactory::generateMemberArray(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('member')
            ->willReturn($memberArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);

        $this->stub->expects($this->exactly(0))
            ->method('translateToObjects');

        $result = $this->stub->search($filter, $sort, $page, $size);
        $this->assertEquals(array(0,array()), $result);
    }
}
