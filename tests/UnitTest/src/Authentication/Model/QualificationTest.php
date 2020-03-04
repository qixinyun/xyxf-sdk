<?php
namespace Sdk\Authentication\Model;

use Sdk\Crew\Model\Crew;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class QualificationTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Qualification::class)
            ->setMethods()->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    //image 测试 ---------------------------------------------------------- start
    /**
     * 设置 Qualification setImage() 正确的传参类型,期望传值正确
     */
    public function testSetImageCorrectType()
    {
        $this->stub->setImage(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getImage());
    }

    /**
     * 设置 Qualification setImage() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetImageWrongType()
    {
        $this->stub->setImage('string');
    }
    //image 测试 ----------------------------------------------------------   end

    //serviceCategory 测试 -------------------------------------------------------- start
    /**
     * 设置 Qualification setServiceCategory() 正确的传参类型,期望传值正确
     */
    public function testSetQualificationServiceCategoryCorrectType()
    {
        $object = new \Sdk\ServiceCategory\Model\ServiceCategory();
        $this->stub->setServiceCategory($object);
        $this->assertSame($object, $this->stub->getServiceCategory());
    }

    /**
     * 设置 Qualification setServiceCategory() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetQualificationServiceCategoryType()
    {
        $this->stub->setServiceCategory(array(1,2,3));
    }
    //serviceCategory 测试 -------------------------------------------------------- end
}
