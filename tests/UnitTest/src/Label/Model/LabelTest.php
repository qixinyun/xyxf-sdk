<?php
namespace Sdk\Label\Model;

use Sdk\Label\Repository\LabelRepository;
use Sdk\Common\Model\IEnableAble;
use Sdk\Crew\Model\Crew;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class LabelTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Label::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends Label{
            public function getRepository() : LabelRepository
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
            'Sdk\Label\Repository\LabelRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setId() 正确的传参类型,期望传值正确
     */
    public function testSetLabelIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 User setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetLabelIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //name 测试 ---------------------------------------------------------- start
    /**
     * 设置 Label setName() 正确的传参类型,期望传值正确
     */
    public function testSetLabelNameCorrectType()
    {
        $this->stub->setName('string');
        $this->assertEquals('string', $this->stub->getName());
    }

    /**
     * 设置 Label setName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetLabelNameWrongType()
    {
        $this->stub->setName(array(1, 2, 3));
    }
    //name 测试 ----------------------------------------------------------   end

    //icon 测试 ---------------------------------------------------------- start
    /**
     * 设置 Label setIcon() 正确的传参类型,期望传值正确
     */
    public function testSetLabelIconCorrectType()
    {
        $this->stub->setIcon(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getIcon());
    }

    /**
     * 设置 Label setIcon() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetLabelIconWrongType()
    {
        $this->stub->setIcon('string');
    }
    //icon 测试 ----------------------------------------------------------   end
    
    //category 测试 ---------------------------------------------------------- start
    /**
     * 设置 Label setCategory() 正确的传参类型,期望传值正确
     */
    public function testSetLabelCategoryCorrectType()
    {
        $this->stub->setCategory(1);
        $this->assertEquals(1, $this->stub->getCategory());
    }

    /**
     * 设置 Label setCategory() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetLabelCategoryWrongTypeButNumeric()
    {
        $this->stub->setCategory('1');
        $this->assertTrue(is_int($this->stub->getCategory()));
        $this->assertEquals(1, $this->stub->getCategory());
    }
    //category 测试 ----------------------------------------------------------   end
 
    //remark 测试 ---------------------------------------------------------- start
    /**
     * 设置 Label setRemark() 正确的传参类型,期望传值正确
     */
    public function testSetLabelRemarkCorrectType()
    {
        $this->stub->setRemark('string');
        $this->assertEquals('string', $this->stub->getRemark());
    }

    /**
     * 设置 Label setRemark() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetLabelRemarkWrongType()
    {
        $this->stub->setRemark(array(1, 2, 3));
    }
    //remark 测试 ----------------------------------------------------------   end

    //crew 测试 -------------------------------------------------------- start
    /**
     * 设置 Crew setCrew() 正确的传参类型,期望传值正确
     */
    public function testSetLabelCrewCorrectType()
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
    public function testSetLabelCrewType()
    {
        $this->stub->setCrew(array(1,2,3));
    }
    //crew 测试 -------------------------------------------------------- end
}
