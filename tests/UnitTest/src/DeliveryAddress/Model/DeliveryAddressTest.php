<?php
namespace Sdk\DeliveryAddress\Model;

use Sdk\DeliveryAddress\Repository\DeliveryAddressRepository;
use Sdk\DeliveryAddress\Repository\DeliveryAddressSessionRepository;
use Sdk\DeliveryAddress\Model\IdentityInfo;

use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IModifyStatusAbleAdapter;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

use Sdk\Member\Model\Member;

class DeliveryAddressTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DeliveryAddress::class)
            ->setMethods(
                [
                'getRepository',
                'IOperatAbleAdapter',
                'IModifyStatusAbleAdapter'
                ]
            )
            ->getMock();

        $this->childStub = new class extends DeliveryAddress {
            public function getRepository() : DeliveryAddressRepository
            {
                return parent::getRepository();
            }
            public function getIOperatAbleAdapter() : IOperatAbleAdapter
            {
                return parent::getIOperatAbleAdapter();
            }
            public function getIModifyStatusAbleAdapter() : IModifyStatusAbleAdapter
            {
                return parent::getIModifyStatusAbleAdapter();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'Sdk\DeliveryAddress\Repository\DeliveryAddressRepository',
            $this->childStub->getRepository()
        );
    }

    public function testCorrectImplementsIObject()
    {
        $this->assertInstanceof('Marmot\Common\Model\IObject', $this->stub);
    }

    public function testCorrectImplementsIOperatAble()
    {
        $this->assertInstanceof('Sdk\Common\Model\IOperatAble', $this->stub);
    }

    public function testCorrectImplementsIModifyStatusAble()
    {
        $this->assertInstanceof('Sdk\Common\Model\IModifyStatusAble', $this->stub);
    }

    public function testGetIOperatAble()
    {
        $this->assertInstanceOf(
            'Sdk\Common\Adapter\IOperatAbleAdapter',
            $this->childStub->getIOperatAbleAdapter()
        );
    }

    public function testGetIModifyStatusAbleAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Common\Adapter\IModifyStatusAbleAdapter',
            $this->childStub->getIModifyStatusAbleAdapter()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 DeliveryAddress setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //area 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setArea() 正确的传参类型,期望传值正确
     */
    public function testSetAreaCorrectType()
    {
        $this->stub->setArea('area');
        $this->assertEquals('area', $this->stub->getArea());
    }

    /**
     * 设置 DeliveryAddress setArea() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAreaWrongType()
    {
        $this->stub->setArea(array());
    }
    //area 测试 --------------------------------------------------------   end
    
    //address 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setAddress() 正确的传参类型,期望传值正确
     */
    public function testSetAddressCorrectType()
    {
        $this->stub->setAddress('address');
        $this->assertEquals('address', $this->stub->getAddress());
    }

    /**
     * 设置 DeliveryAddress setAddress() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAddressWrongType()
    {
        $this->stub->setAddress(array());
    }
    //address 测试 --------------------------------------------------------   end
    
    //postalCode 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setPostalCode() 正确的传参类型,期望传值正确
     */
    public function testSetPostalCodeCorrectType()
    {
        $this->stub->setPostalCode('715690');
        $this->assertEquals('715690', $this->stub->getPostalCode());
    }

    /**
     * 设置 DeliveryAddress setPostalCode() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPostalCodeWrongType()
    {
        $this->stub->setPostalCode(array());
    }
    //postalCode 测试 --------------------------------------------------------   end

    //realName 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setRealName() 正确的传参类型,期望传值正确
     */
    public function testSetRealNameCorrectType()
    {
        $this->stub->setRealName('realName');
        $this->assertEquals('realName', $this->stub->getRealName());
    }

    /**
     * 设置 DeliveryAddress setRealName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRealNameWrongType()
    {
        $this->stub->setRealName(array());
    }
    //realName 测试 --------------------------------------------------------   end
    
    //cellphone 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setCellphone() 正确的传参类型,期望传值正确
     */
    public function testSetCellphoneCorrectType()
    {
        $this->stub->setCellphone('13202938747');
        $this->assertEquals('13202938747', $this->stub->getCellphone());
    }

    /**
     * 设置 DeliveryAddress setCellphone() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCellphoneWrongType()
    {
        $this->stub->setCellphone(array());
    }
    //cellphone 测试 --------------------------------------------------------   end
    
    //isDefaultAddress 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setIsDefaultAddress() 正确的传参类型,期望传值正确
     */
    public function testSetIsDefaultAddressCorrectType()
    {
        $this->stub->setIsDefaultAddress(0);
        $this->assertEquals(0, $this->stub->getIsDefaultAddress());
    }

    /**
     * 设置 DeliveryAddress setIsDefaultAddress() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetIsDefaultAddressWrongType()
    {
        $this->stub->setIsDefaultAddress('string');
    }
    //isDefaultAddress 测试 --------------------------------------------------------   end
    
    //member 测试 -------------------------------------------------------- start
    /**
     * 设置 DeliveryAddress setMember() 正确的传参类型,期望传值正确
     */
    public function testSetMemberCorrectType()
    {
        $object = new Member();
        $this->stub->setMember($object);
        $this->assertSame($object, $this->stub->getMember());
    }

    /**
     * 设置 DeliveryAddress setMember() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetMemberType()
    {
        $this->stub->setMember(array(1,2,3));
    }
    //member 测试 -------------------------------------------------------- end
}
