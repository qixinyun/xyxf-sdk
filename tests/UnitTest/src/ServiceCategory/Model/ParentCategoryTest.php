<?php
namespace Sdk\ServiceCategory\Model;

use Sdk\ServiceCategory\Repository\ParentCategoryRepository;

use PHPUnit\Framework\TestCase;

class ParentCategoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ParentCategory::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends ParentCategory{
            public function getRepository() : ParentCategoryRepository
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
            'Sdk\ServiceCategory\Repository\ParentCategoryRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 ParentCategory setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(2);
        $this->assertEquals(2, $this->stub->getId());
    }

    /**
     * 设置 ParentCategory setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('3');
        $this->assertEquals(3, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //name 测试 ---------------------------------------------------------- start
    /**
     * 设置 ParentCategory setName() 正确的传参类型,期望传值正确
     */
    public function testSetNameCorrectType()
    {
        $this->stub->setName('string');
        $this->assertEquals('string', $this->stub->getName());
    }

    /**
     * 设置 ParentCategory setName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNameWrongType()
    {
        $this->stub->setName(array(1, 2));
    }
    //name 测试 ----------------------------------------------------------   end
}
