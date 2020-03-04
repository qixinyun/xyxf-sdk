<?php
namespace Sdk\DispatchDepartment\Model;

use Sdk\DispatchDepartment\Repository\DispatchDepartmentRepository;
use Sdk\Common\Model\IEnableAble;
use Sdk\Crew\Model\Crew;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class DispatchDepartmentTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DispatchDepartment::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends DispatchDepartment{
            public function getRepository() : DispatchDepartmentRepository
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
            'Sdk\DispatchDepartment\Repository\DispatchDepartmentRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 User setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertTrue(is_int($this->stub->getId()));
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //name 测试 ---------------------------------------------------------- start
    /**
     * 设置 DispatchDepartment setName() 正确的传参类型,期望传值正确
     */
    public function testSetNameCorrectType()
    {
        $this->stub->setName('string');
        $this->assertEquals('string', $this->stub->getName());
    }

    /**
     * 设置 DispatchDepartment setName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNameWrongType()
    {
        $this->stub->setName(array(1, 2, 3));
    }
    //name 测试 ----------------------------------------------------------   end
 
    //remark 测试 ---------------------------------------------------------- start
    /**
     * 设置 DispatchDepartment setRemark() 正确的传参类型,期望传值正确
     */
    public function testSetRemarkCorrectType()
    {
        $this->stub->setRemark('string');
        $this->assertEquals('string', $this->stub->getRemark());
    }

    /**
     * 设置 DispatchDepartment setRemark() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRemarkWrongType()
    {
        $this->stub->setRemark(array(1, 2, 3));
    }
    //remark 测试 ----------------------------------------------------------   end

    //crew 测试 -------------------------------------------------------- start
    /**
     * 设置 Crew setCrew() 正确的传参类型,期望传值正确
     */
    public function testSetCrewCorrectType()
    {
        $object = new Crew();
        $this->stub->setCrew($object);
        $this->assertSame($object, $this->stub->getCrew());
    }

    /**
     * 设置 Crew setCrew() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCrewType()
    {
        $this->stub->setCrew(array(1,2,3));
    }
    //crew 测试 -------------------------------------------------------- end
}
