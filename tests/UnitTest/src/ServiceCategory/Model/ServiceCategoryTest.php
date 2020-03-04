<?php
namespace Sdk\ServiceCategory\Model;

use Sdk\ServiceCategory\Repository\ServiceCategoryRepository;

use PHPUnit\Framework\TestCase;

class ServiceCategoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ServiceCategory::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends ServiceCategory{
            public function getRepository() : ServiceCategoryRepository
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
            'Sdk\ServiceCategory\Repository\ServiceCategoryRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceCategory setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(2);
        $this->assertEquals(2, $this->stub->getId());
    }

    /**
     * 设置 ServiceCategory setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('2');
        $this->assertEquals(2, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //name 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceCategory setName() 正确的传参类型,期望传值正确
     */
    public function testSetNameCorrectType()
    {
        $this->stub->setName('string');
        $this->assertEquals('string', $this->stub->getName());
    }

    /**
     * 设置 ServiceCategory setName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNameWrongType()
    {
        $this->stub->setName(array(1, 2, 3));
    }
    //name 测试 ----------------------------------------------------------   end
    
    //parentCategory 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceCategory setParentCategory() 正确的传参类型,期望传值正确
     */
    public function testSetParentCategoryCorrectType()
    {
        $parentCategory = new parentCategory();
        $this->stub->setParentCategory($parentCategory);
        $this->assertEquals($parentCategory, $this->stub->getParentCategory());
    }

    /**
     * 设置 ServiceCategory setParentCategory() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetParentCategoryWrongType()
    {
        $this->stub->setParentCategory(array(1, 2, 3));
    }
    //parentCategory 测试 ----------------------------------------------------------   end
    
    //isQualification 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceCategory setIsQualification() 正确的传参类型,期望传值正确
     */
    public function testSetIsQualificationCorrectType()
    {
        $this->stub->setIsQualification(2);
        $this->assertEquals(2, $this->stub->getIsQualification());
    }

    /**
     * 设置 ServiceCategory setIsQualification() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetIsQualificationWrongType()
    {
        $this->stub->setIsQualification('string');
    }
    //isQualification 测试 ----------------------------------------------------------   end

    //qualificationName 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceCategory setQualificationName() 正确的传参类型,期望传值正确
     */
    public function testSetQualificationNameCorrectType()
    {
        $this->stub->setQualificationName('string');
        $this->assertEquals('string', $this->stub->getQualificationName());
    }

    /**
     * 设置 ServiceCategory setQualificationName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetQualificationNameWrongType()
    {
        $this->stub->setQualificationName(array(1, 2, 3));
    }
    //qualificationName 测试 ----------------------------------------------------------   end

    //commission 测试 ---------------------------------------------------------- start
    /**
     * 设置 ServiceCategory setCommission() 正确的传参类型,期望传值正确
     */
    public function testSetCommissionCorrectType()
    {
        $this->stub->setCommission(1.1);
        $this->assertEquals(1.1, $this->stub->getCommission());
    }

    /**
     * 设置 ServiceCategory setCommission() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCommissionWrongType()
    {
        $this->stub->setCommission('string');
    }
    //commission 测试 ----------------------------------------------------------   end
}
