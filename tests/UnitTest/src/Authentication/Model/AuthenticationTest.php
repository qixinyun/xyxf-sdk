<?php
namespace Sdk\Authentication\Model;

use Sdk\Authentication\Repository\AuthenticationRepository;
use Sdk\Crew\Model\Crew;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class AuthenticationTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Authentication::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends Authentication{
            public function getRepository() : AuthenticationRepository
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
            'Sdk\Authentication\Repository\AuthenticationRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 Authentication setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 Authentication setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end
    
    //enterpriseName 测试 ---------------------------------------------------------- start
    /**
     * 设置 Authentication setEnterpriseName() 正确的传参类型,期望传值正确
     */
    public function testSetEnterpriseNameCorrectType()
    {
        $this->stub->setEnterpriseName('string');
        $this->assertEquals('string', $this->stub->getEnterpriseName());
    }

    /**
     * 设置 Authentication setEnterpriseName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetEnterpriseNameWrongType()
    {
        $this->stub->setEnterpriseName(array(1, 2, 3));
    }
    //enterpriseName 测试 ----------------------------------------------------------   end
    
    //serviceCategory 测试 -------------------------------------------------------- start
    /**
     * 设置 Authentication setServiceCategory() 正确的传参类型,期望传值正确
     */
    public function testSetServiceCategoryCorrectType()
    {
        $object = new \Sdk\ServiceCategory\Model\ServiceCategory();
        $this->stub->setServiceCategory($object);
        $this->assertSame($object, $this->stub->getServiceCategory());
    }

    /**
     * 设置 Authentication setServiceCategory() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetServiceCategoryType()
    {
        $this->stub->setServiceCategory(array(1,2,3));
    }
    //serviceCategory 测试 -------------------------------------------------------- end
    
    //Enterprise 测试 -------------------------------------------------------- start
    /**
     * 设置 Authentication setEnterprise() 正确的传参类型,期望传值正确
     */
    public function testSetEnterpriseCorrectType()
    {
        $object = new \Sdk\Enterprise\Model\Enterprise();
        $this->stub->setEnterprise($object);
        $this->assertSame($object, $this->stub->getEnterprise());
    }

    /**
     * 设置 Authentication setEnterprise() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetEnterpriseType()
    {
        $this->stub->setEnterprise(array(1,2,3));
    }
    //Enterprise 测试 -------------------------------------------------------- end

    //rejectReason 测试 ---------------------------------------------------------- start
    /**
     * 设置 Authentication setRejectReason() 正确的传参类型,期望传值正确
     */
    public function testSetRejectReasonCorrectType()
    {
        $this->stub->setRejectReason('string');
        $this->assertEquals('string', $this->stub->getRejectReason());
    }

    /**
     * 设置 Authentication setRejectReason() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRejectReasonWrongType()
    {
        $this->stub->setRejectReason(array(1, 2, 3));
    }
    //rejectReason 测试 ----------------------------------------------------------   end

    //qualifications 测试 -------------------------------------------------------- start
    /**
     * 设置 Authentication setQualifications() 正确的传参类型,期望传值正确
     */
    public function testAddQualificationsCorrectType()
    {
        $object = new Qualification();
        $this->stub->addQualification($object);
        $this->assertSame(array($object), $this->stub->getQualifications());
    }

    /**
     * 设置 Authentication setQualifications() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testAddQualificationsType()
    {
        $this->stub->addQualification('string');
    }
    //qualifications 测试 -------------------------------------------------------- end
}
