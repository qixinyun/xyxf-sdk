<?php
namespace Sdk\NaturalPerson\Translator;

use Sdk\NaturalPerson\Model\NullNaturalPerson;
use Sdk\NaturalPerson\Model\NaturalPerson;
use Sdk\NaturalPerson\Model\IdentityInfo;
use Sdk\Common\Model\IdentifyCard;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Member\Translator\MemberRestfulTranslator;
use Sdk\Member\Model\Member;

class NaturalPersonRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            NaturalPersonRestfulTranslator::class
        )
            ->setMethods(['getMemberRestfulTranslator'])
            ->getMock();

        $this->childStub =
        new class extends NaturalPersonRestfulTranslator {
            public function getMemberRestfulTranslator() : MemberRestfulTranslator
            {
                return parent::getMemberRestfulTranslator();
            }
        };
        parent::setUp();
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
        $result = $this->stub->arrayToObject(array(), new NaturalPerson());
        $this->assertInstanceOf('Sdk\NaturalPerson\Model\NullNaturalPerson', $result);
    }

    public function setMethods(NaturalPerson $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['realName'])) {
            $expectObject->setRealName($attributes['realName']);
        }
        if (isset($attributes['rejectReason'])) {
            $expectObject->setRejectReason($attributes['rejectReason']);
        }

        $cardId = isset($attributes['cardId'])
        ? $attributes['cardId']
        : '';
        $positivePhoto = isset($attributes['positivePhoto'])
        ? $attributes['positivePhoto']
        : array();
        $reversePhoto = isset($attributes['reversePhoto'])
        ? $attributes['reversePhoto']
        : array();
        $handHeldPhoto = isset($attributes['handheldPhoto'])
        ? $attributes['handheldPhoto']
        : array();

        $expectObject->setIdentityInfo(
            new IdentityInfo(
                $cardId,
                $positivePhoto,
                $reversePhoto,
                $handHeldPhoto
            )
        );

        if (isset($attributes['applyStatus'])) {
            $expectObject->setApplyStatus($attributes['applyStatus']);
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


    public function testArrayToObjectCorrectObject()
    {
        $naturalPerson = \Sdk\NaturalPerson\Utils\MockFactory::generateNaturalPersonArray();

        $data =  $naturalPerson['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObject($naturalPerson);

        $expectObject = new NaturalPerson();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->stub->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $naturalPerson = \Sdk\NaturalPerson\Utils\MockFactory::generateNaturalPersonArray();
        $data =  $naturalPerson['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($naturalPerson);
        $expectArray = array();

        $expectObject = new NaturalPerson();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $expectArray = [1, [$data['id']=>$expectObject]];

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
        $naturalPerson = \Sdk\NaturalPerson\Utils\MockFactory::generateNaturalPersonObject(1, 1);

        $actual = $this->stub->objectToArray($naturalPerson);
        
        $expectedArray = array(
            'data'=>array(
                'type'=>'naturalPersons',
                'id'=>$naturalPerson->getId()
            )
        );

        $expectedArray['data']['attributes'] = array(
            'realName'=>$naturalPerson->getRealName(),
            'cardId'=>$naturalPerson->getIdentityInfo()->getCardId(),
            'positivePhoto'=>$naturalPerson->getIdentityInfo()->getPositivePhoto(),
            'reversePhoto'=>$naturalPerson->getIdentityInfo()->getReversePhoto(),
            'handheldPhoto'=>$naturalPerson->getIdentityInfo()->getHandHeldPhoto(),
            'rejectReason'=>$naturalPerson->getRejectReason(),
        );

        $expectedArray['data']['relationships']['member']['data'] = array(
            array(
                'type' => 'members',
                'id' => $naturalPerson->getMember()->getId()
            )
        );
        
        $this->assertEquals($expectedArray, $actual);
    }
}
