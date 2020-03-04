<?php
namespace Sdk\Member\Adapter\Member;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Member\Model\Member;
use Sdk\Member\Model\NullMember;
use Sdk\Member\Utils\MockFactory;
use Sdk\Member\Translator\MemberRestfulTranslator;

class MemberRestfulAdapterTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(MemberRestfulAdapter::class)
            ->setMethods(
                ['fetchOneAction','isSuccess','post','patch','translateToObject','getTranslator']
            )->getMock();

        $this->childStub = new class extends MemberRestfulAdapter
        {
            public function getResource() : string
            {
                return parent::getResource();
            }

            public function getTranslator() : IRestfulTranslator
            {
                return parent::getTranslator();
            }

            public function getScenario() : array
            {
                return parent::getScenario();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testImplementsIMemberAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Member\Adapter\Member\IMemberAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('members', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Member\Translator\MemberRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }

    /**
     * @dataProvider scenarioDataProvider
     */
    public function testScenario($expect, $actual)
    {
        $this->childStub->scenario($expect);
        $this->assertEquals($actual, $this->childStub->getScenario());
    }

    public function scenarioDataProvider()
    {
        return [
            ['MEMBER_LIST', MemberRestfulAdapter::SCENARIOS['MEMBER_LIST']],
            ['MEMBER_FETCH_ONE', MemberRestfulAdapter::SCENARIOS['MEMBER_FETCH_ONE']],
            ['NULL', array()]
        ];
    }

    public function testFetchOne()
    {
        $id = 1;

        $member = MockFactory::generateMemberObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullMember())
            ->willReturn($member);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($member, $result);
    }

    private function prepareMemberTranslator(Member $member, array $keys, array $memberArray)
    {
        $translator = $this->prophesize(MemberRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($member),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($memberArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Member $member)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($member);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }

    public function testSignUpSuccess()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone','password'),
            $memberArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('members/signUp', $memberArray);

        $this->success($member);
        
        $result = $this->stub->signUp($member);
        $this->assertTrue($result);
    }

    public function testSignUpFailure()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone','password'),
            $memberArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('members/signUp', $memberArray);

        $this->failure($member);
        $result = $this->stub->signUp($member);
        $this->assertFalse($result);
    }

    public function testSignInFailure()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone', 'password'),
            $memberArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('members/signIn', $memberArray);

        $this->failure($member);
        $result = $this->stub->signIn($member);
        $this->assertFalse($result);
    }

    public function testResetPasswordSuccess()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone', 'password'),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/resetPassword', $memberArray);

        $this->success($member);
        $result = $this->stub->resetPassword($member);
        $this->assertTrue($result);
    }

    public function testResetPasswordFailure()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone', 'password'),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/resetPassword', $memberArray);

        $this->failure($member);
        $result = $this->stub->resetPassword($member);
        $this->assertFalse($result);
    }

    public function testUpdatePasswordSuccess()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('oldPassword', 'password'),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/'.$member->getId().'/updatePassword', $memberArray);

        $this->success($member);
        $result = $this->stub->updatePassword($member);
        $this->assertTrue($result);
    }

    public function testUpdatePasswordFailure()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('oldPassword', 'password'),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/'.$member->getId().'/updatePassword', $memberArray);

        $this->failure($member);
        $result = $this->stub->updatePassword($member);
        $this->assertFalse($result);
    }

    public function testUpdateCellphoneSuccess()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone'),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/'.$member->getId().'/updateCellphone', $memberArray);

        $this->success($member);
        $result = $this->stub->updateCellphone($member);
        $this->assertTrue($result);
    }

    public function testUpdateCellphoneFailure()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array('cellphone'),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/'.$member->getId().'/updateCellphone', $memberArray);

        $this->failure($member);
        $result = $this->stub->updateCellphone($member);
        $this->assertFalse($result);
    }

    public function testEditSuccess()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array(
                'nickName',
                'gender',
                'avatar',
                'birthday',
                'area',
                'address',
                'briefIntroduction'
            ),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/'.$member->getId(), $memberArray);

        $this->success($member);
        $result = $this->stub->edit($member);
        $this->assertTrue($result);
    }

    public function testEditFailure()
    {
        $member = MockFactory::generateMemberObject(1);
        $memberArray = array('members');

        $this->prepareMemberTranslator(
            $member,
            array(
                'nickName',
                'gender',
                'avatar',
                'birthday',
                'area',
                'address',
                'briefIntroduction'
            ),
            $memberArray
        );

        $this->stub
            ->method('patch')
            ->with('members/'.$member->getId(), $memberArray);

        $this->failure($member);
        $result = $this->stub->edit($member);
        $this->assertFalse($result);
    }
}
