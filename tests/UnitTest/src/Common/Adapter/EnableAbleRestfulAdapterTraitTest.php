<?php
namespace Sdk\Common\Adapter;

use PHPUnit\Framework\TestCase;

use Sdk\Common\Model\IEnableAble;
use Sdk\Member\Utils\MockFactory;

class EnableAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestEnableAbleRestfulAdapter::class)
            ->setMethods(
                [
                    'patch',
                    'isSuccess',
                    'translateToObject',
                    'getTranslator'
                ]
            )->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    private function success(IEnableAble $enableAbleObject)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($enableAbleObject);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }

    public function testEnableSuccess()
    {
        $member = MockFactory::generateMemberObject(1);
        
        $url = 'member/'.$member->getId().'/enable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->success($member);

        $result = $this->stub->enable($member);
        $this->assertTrue($result);
    }
    
    public function testEnableFailure()
    {
        $member = MockFactory::generateMemberObject(1);

        $url = 'member/'.$member->getId().'/enable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->failure($member);
        $result = $this->stub->enable($member);
        $this->assertFalse($result);
    }

    public function testDisableSuccess()
    {
        $member = MockFactory::generateMemberObject(1);

        $url = 'member/'.$member->getId().'/disable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->success($member);

        $result = $this->stub->disable($member);
        $this->assertTrue($result);
    }

    public function testDisableFailure()
    {
        $member = MockFactory::generateMemberObject(1);

        $url = 'member/'.$member->getId().'/disable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->failure($member);
        $result = $this->stub->disable($member);
        $this->assertFalse($result);
    }
}
