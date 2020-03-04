<?php
namespace Sdk\DeliveryAddress\Translator;

use Sdk\DeliveryAddress\Model\NullDeliveryAddress;
use Sdk\DeliveryAddress\Model\DeliveryAddress;
use Sdk\DeliveryAddress\Model\IdentityInfo;
use Sdk\Common\Model\IdentifyCard;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Member\Translator\MemberRestfulTranslator;
use Sdk\Member\Model\Member;

class DeliveryAddressRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            DeliveryAddressRestfulTranslator::class
        )
            ->setMethods(['getMemberRestfulTranslator'])
            ->getMock();

        $this->childStub =
        new class extends DeliveryAddressRestfulTranslator {
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
        $result = $this->stub->arrayToObject(array(), new DeliveryAddress());
        $this->assertInstanceOf('Sdk\DeliveryAddress\Model\NullDeliveryAddress', $result);
    }

    public function setMethods(DeliveryAddress $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['area'])) {
            $expectObject->setArea($attributes['area']);
        }
        if (isset($attributes['address'])) {
            $expectObject->setAddress($attributes['address']);
        }
        if (isset($attributes['postalCode'])) {
            $expectObject->setPostalCode($attributes['postalCode']);
        }
        if (isset($attributes['realName'])) {
            $expectObject->setRealName($attributes['realName']);
        }
        if (isset($attributes['cellphone'])) {
            $expectObject->setCellphone($attributes['cellphone']);
        }
        if (isset($attributes['isDefaultAddress'])) {
            $expectObject->setIsDefaultAddress($attributes['isDefaultAddress']);
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
        $deliveryAddress = \Sdk\DeliveryAddress\Utils\MockFactory::generateDeliveryAddressArray();

        $data =  $deliveryAddress['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObject($deliveryAddress);

        $expectObject = new DeliveryAddress();

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
        $deliveryAddress = \Sdk\DeliveryAddress\Utils\MockFactory::generateDeliveryAddressArray();
        $data =  $deliveryAddress['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($deliveryAddress);
        $expectArray = array();

        $expectObject = new DeliveryAddress();

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
        $deliveryAddress = \Sdk\DeliveryAddress\Utils\MockFactory::generateDeliveryAddressObject(1, 1);

        $actual = $this->stub->objectToArray($deliveryAddress, array(
            'id',
            'area',
            'address',
            'postalCode',
            'realName',
            'cellphone',
            'isDefaultAddress',
            'member'
        ));
        
        $expectedArray = array(
            'data'=>array(
                'type'=>'deliveryAddress',
                'id'=>$deliveryAddress->getId()
            )
        );

        $expectedArray['data']['attributes'] = array(
            'area'=>$deliveryAddress->getArea(),
            'address'=>$deliveryAddress->getAddress(),
            'postalCode'=>$deliveryAddress->getPostalCode(),
            'realName'=>$deliveryAddress->getRealName(),
            'cellphone'=>$deliveryAddress->getCellphone(),
            'isDefaultAddress'=>$deliveryAddress->getIsDefaultAddress(),
        );

        $expectedArray['data']['relationships']['member']['data'] = array(
            array(
                'type' => 'members',
                'id' => $deliveryAddress->getMember()->getId()
            )
        );
        
        $this->assertEquals($expectedArray, $actual);
    }
}
