<?php
namespace Sdk\ServiceRequirement\Model;

use Sdk\ServiceRequirement\Repository\ServiceRequirementRepository;
use Sdk\Common\Model\IEnableAble;
use Sdk\Member\Model\Member;
use Sdk\ServiceCategory\Model\ServiceCategory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class ServiceRequirementTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ServiceRequirement::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends ServiceRequirement{
            public function getRepository() : ServiceRequirementRepository
            {
                return parent::getRepository();
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
            'Sdk\ServiceRequirement\Repository\ServiceRequirementRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 ServiceRequirement setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //title 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setTitle() 正确的传参类型,期望传值正确
     */
    public function testSetTitleCorrectType()
    {
        $this->stub->setTitle('Servicerequirement');
        $this->assertEquals('Servicerequirement', $this->stub->getTitle());
    }

    /**
     * 设置 ServiceRequirement setTitle() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetTitleWrongType()
    {
        $this->stub->setTitle(array(1, 2, 3));
    }
    //title 测试 ----------------------------------------------------------   end
    
    //detail 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setDetail() 正确的传参类型,期望传值正确
     */
    public function testSetDetailCorrectType()
    {
        $this->stub->setDetail(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getDetail());
    }

    /**
     * 设置 ServiceRequirement setDetail() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetDetailWrongType()
    {
        $this->stub->setDetail('string');
    }
    //detail 测试 ----------------------------------------------------------   end

    //minPrice 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setMinPrice() 正确的传参类型,期望传值正确
     */
    public function testSetMinPriceCorrectType()
    {
        $this->stub->setMinPrice(1.01);
        $this->assertEquals(1.01, $this->stub->getMinPrice());
    }

    /**
     * 设置 ServiceRequirement setMinPrice() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetMinPriceWrongTypeButNumeric()
    {
        $this->stub->setMinPrice('1');
        $this->assertEquals(1, $this->stub->getMinPrice());
    }
    //minPrice 测试 ----------------------------------------------------------   end

    //MaxPrice 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setMaxPrice() 正确的传参类型,期望传值正确
     */
    public function testSetMaxPriceCorrectType()
    {
        $this->stub->setMaxPrice(10000.01);
        $this->assertEquals(10000.01, $this->stub->getMaxPrice());
    }

    /**
     * 设置 ServiceRequirement setMaxPrice() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetMaxpriceWrongTypeButNumeric()
    {
        $this->stub->setMaxPrice('1');
        $this->assertEquals(1, $this->stub->getMaxPrice());
    }
    //MaxPrice 测试 ----------------------------------------------------------   end

    //validityStartTime 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setValidityStartTime() 正确的传参类型,期望传值正确
     */
    public function testSetValidityStartTimeCorrectType()
    {
        $time = time();
        $this->stub->setValidityStartTime($time);
        $this->assertEquals($time, $this->stub->getValidityStartTime());
    }

    /**
     * 设置 ServiceRequirement setValidityStartTime() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetValidityStartTimeWrongTypeButNumeric()
    {
        $this->stub->setValidityStartTime('1');
        $this->assertEquals(1, $this->stub->getValidityStartTime());
    }
    //validityStartTime 测试 ----------------------------------------------------------   end

    //validityEndTime 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setValidityEndTime() 正确的传参类型,期望传值正确
     */
    public function testSetValidityEndTimeCorrectType()
    {
        $time = time();
        $this->stub->setValidityEndTime($time);
        $this->assertEquals($time, $this->stub->getValidityEndTime());
    }

    /**
     * 设置 ServiceRequirement setValidityEndTime() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetValidityEndTimeWrongTypeButNumeric()
    {
        $this->stub->setValidityEndTime('1');
        $this->assertEquals(1, $this->stub->getValidityEndTime());
    }
    //validityEndTime 测试 ----------------------------------------------------------   end

    //contactName 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setContactName() 正确的传参类型,期望传值正确
     */
    public function testSetContactNameCorrectType()
    {
        $this->stub->setContactName('string');
        $this->assertEquals('string', $this->stub->getContactName());
    }

    /**
     * 设置 ServiceRequirement setContactName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetContactNameWrongType()
    {
        $this->stub->setContactName(array(1, 2, 3));
    }
    //contactName 测试 ----------------------------------------------------------   end

    //contactPhone 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setContactPhone() 正确的传参类型,期望传值正确
     */
    public function testSetContactPhoneCorrectType()
    {
        $this->stub->setContactPhone('string');
        $this->assertEquals('string', $this->stub->getContactPhone());
    }

    /**
     * 设置 ServiceRequirement setContactPhone() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetContactPhoneWrongType()
    {
        $this->stub->setContactPhone(array(1, 2, 3));
    }
    //contactPhone 测试 ----------------------------------------------------------   end

    //rejectReason 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setRejectReason() 正确的传参类型,期望传值正确
     */
    public function testSetRejectReasonCorrectType()
    {
        $this->stub->setRejectReason('string');
        $this->assertEquals('string', $this->stub->getRejectReason());
    }

    /**
     * 设置 ServiceRequirement setRejectReason() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRejectReasonWrongType()
    {
        $this->stub->setRejectReason(array(1, 2, 3));
    }
    //rejectReason 测试 ----------------------------------------------------------   end
    
    //serviceCategory 测试 -------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setServiceCategory() 正确的传参类型,期望传值正确
     */
    public function testSetServiceCategoryCorrectType()
    {
        $object = new ServiceCategory();
        $this->stub->setServiceCategory($object);
        $this->assertSame($object, $this->stub->getServiceCategory());
    }

    /**
     * 设置 ServiceRequirement setServiceCategory() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetServiceCategoryType()
    {
        $this->stub->setServiceCategory(array(1,2,3));
    }
    //serviceCategory 测试 -------------------------------------------------------- end

    //membre 测试 -------------------------------------------------------- start
    /**
     * 设置 ServiceRequirement setServiceCategory() 正确的传参类型,期望传值正确
     */
    public function testSetMemberCorrectType()
    {
        $object = new Member();
        $this->stub->setMember($object);
        $this->assertSame($object, $this->stub->getMember());
    }

    /**
     * 设置 ServiceRequirement setMember() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetMemberType()
    {
        $this->stub->setMember(array(1,2,3));
    }
    //membre 测试 -------------------------------------------------------- end
}
