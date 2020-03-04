<?php
namespace Sdk\MemberAccount\Translator;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\MemberAccount\Model\MemberAccount;
use Sdk\Member\Model\Member;
use Sdk\Member\Translator\MemberRestfulTranslator;

class MemberAccountRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            MemberAccountRestfulTranslator::class
        )
            ->setMethods([
                'getMemberRestfulTranslator'
            ])
            ->getMock();

        $this->childStub =
        new class extends MemberAccountRestfulTranslator
        {
            public function getMemberRestfulTranslator(): MemberRestfulTranslator
            {
                return parent::getMemberRestfulTranslator();
            }
        };
    }

    public function testGetMemberRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Member\Translator\MemberRestfulTranslator',
            $this->childStub->getMemberRestfulTranslator()
        );
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new MemberAccount());
        $this->assertInstanceOf('Sdk\MemberAccount\Model\NullMemberAccount', $result);
    }

    public function setMethods(MemberAccount $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['accountBalance'])) {
            $expectObject->setAccountBalance($attributes['accountBalance']);
        }
        if (isset($attributes['frozenAccountBalance'])) {
            $expectObject->setFrozenAccountBalance($attributes['frozenAccountBalance']);
        }
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }
        if (isset($attributes['createTime'])) {
            $expectObject->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $expectObject->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['statusTime'])) {
            $expectObject->setStatusTime($attributes['statusTime']);
        }
        if (isset($relationships['member']['data'])) {
            $expectObject->setMember(new Member($relationships['member']['data']['id']));
        }

        return $expectObject;
    }

    private function establishingPrediction($memberAccount, $data, $relationships)
    {
        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());
    }

    public function testArrayToObjectCorrectObject()
    {
        $memberAccount = \Sdk\MemberAccount\Utils\MockFactory::generateMemberAccountArray();

        $data = $memberAccount['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($memberAccount, $data, $relationships);

        $actual = $this->stub->arrayToObject($memberAccount);

        $expectObject = new MemberAccount();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->stub->arrayToObjects(array());
        $this->assertEquals(array(0, array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $memberAccount = \Sdk\MemberAccount\Utils\MockFactory::generateMemberAccountArray();

        $data = $memberAccount['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($memberAccount, $data, $relationships);

        $actual = $this->stub->arrayToObjects($memberAccount);

        $expectArray = array();

        $expectObject = new MemberAccount();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $expectArray = [1, [$data['id'] => $expectObject]];

        $this->assertEquals($expectArray, $actual);
    }
    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->stub->objectToArray(null);
        $this->assertEquals(array(), $result);
    }
    /**
     * 传参正确对象, 返回对应数组
     */
    public function testObjectToArrayCorrectObject()
    {
        $memberAccount = \Sdk\MemberAccount\Utils\MockFactory::generateMemberAccountObject(1, 1);

        $actual = $this->stub->objectToArray($memberAccount);

        $expectedArray = array(
            'data' => array(
                'type' => 'memberAccounts',
            ),
        );

        $expectedArray['data']['attributes'] = array(
            'accountBalance' => $memberAccount->getAccountBalance(),
            'frozenAccountBalance' => $memberAccount->getFrozenAccountBalance(),
        );

        $expectedArray['data']['relationships']['member']['data'] = array(
            array(
                'type' => 'members',
                'id' => $memberAccount->getMember()->getId(),
            ),
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
