<?php
namespace Sdk\ServiceCategory\Translator;

use Sdk\ServiceCategory\Model\NullParentCategory;
use Sdk\ServiceCategory\Model\ParentCategory;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ParentCategoryRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            ParentCategoryRestfulTranslator::class
        )
            ->setMethods()
            ->getMock();

        $this->childStub =
        new class extends ParentCategoryRestfulTranslator {
        };
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new ParentCategory());
        $this->assertInstanceOf('Sdk\ServiceCategory\Model\NullParentCategory', $result);
    }

    public function setMethods(ParentCategory $expectObject, array $attributes)
    {
        if (isset($attributes['name'])) {
            $expectObject->setName($attributes['name']);
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

        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $parentCategory = \Sdk\ServiceCategory\Utils\MockFactory::generateParentCategoryArray();

        $data =  $parentCategory['data'];

        $actual = $this->stub->arrayToObject($parentCategory);

        $expectObject = new ParentCategory();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->stub->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $parentCategory = \Sdk\ServiceCategory\Utils\MockFactory::generateParentCategoryArray();
        $data =  $parentCategory['data'];

        $actual = $this->stub->arrayToObjects($parentCategory);

        $expectArray = array();

        $expectObject = new ParentCategory();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes);

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
        $parentCategory = \Sdk\ServiceCategory\Utils\MockFactory::generateParentCategoryObject(1, 1);

        $actual = $this->stub->objectToArray($parentCategory);

        $expectedArray = array(
            'data'=>array(
                'type'=>'parentCategories'
            )
        );

        $expectedArray['data']['attributes'] = array(
            'name'=>$parentCategory->getName()
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
