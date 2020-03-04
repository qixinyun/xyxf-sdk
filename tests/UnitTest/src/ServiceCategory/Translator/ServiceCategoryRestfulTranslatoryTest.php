<?php
namespace Sdk\ServiceCategory\Translator;

use Sdk\ServiceCategory\Model\NullServiceCategory;
use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Model\ParentCategory;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ServiceCategoryRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            ServiceCategoryRestfulTranslator::class
        )
            ->setMethods(['getParentCategoryRestfulTranslator'])
            ->getMock();

        $this->childStub =
        new class extends ServiceCategoryRestfulTranslator {
            public function getParentCategoryRestfulTranslator()
            {
                return parent::getParentCategoryRestfulTranslator();
            }
        };
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new ServiceCategory());
        $this->assertInstanceOf('Sdk\ServiceCategory\Model\NullServiceCategory', $result);
    }

    public function setMethods(ServiceCategory $serviceCategory, array $attributes, array $relationships)
    {
        if (isset($attributes['name'])) {
            $serviceCategory->setName($attributes['name']);
        }
        if (isset($attributes['isQualification'])) {
            $serviceCategory->setIsQualification($attributes['isQualification']);
        }
        if (isset($attributes['qualificationName'])) {
            $serviceCategory->setQualificationName($attributes['qualificationName']);
        }
        if (isset($attributes['commission'])) {
            $serviceCategory->setCommission($attributes['commission']);
        }
        if (isset($attributes['status'])) {
            $serviceCategory->setStatus($attributes['status']);
        }
        if (isset($attributes['createTime'])) {
            $serviceCategory->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $serviceCategory->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['statusTime'])) {
            $serviceCategory->setStatusTime($attributes['statusTime']);
        }

        if (isset($relationships['parentCategory']['data'])) {
            $serviceCategory->setParentCategory(new ParentCategory($relationships['parentCategory']['data']['id']));
        }

        return $serviceCategory;
    }

    public function testArrayToObjectCorrectObject()
    {
        $serviceCategory = \Sdk\ServiceCategory\Utils\MockFactory::generateServiceCategoryArray();

        $data =  $serviceCategory['data'];
        $relationships = $data['relationships'];

        $parentCategory = new ParentCategory($relationships['parentCategory']['data']['id']);
        
        $parentCategoryRestfulTranslator = $this->prophesize(ParentCategoryRestfulTranslator::class);
        $parentCategoryRestfulTranslator->arrayToObject(Argument::exact($relationships['parentCategory']))
            ->shouldBeCalledTimes(1)->willReturn($parentCategory);

        $this->stub->expects($this->exactly(1))
            ->method('getParentCategoryRestfulTranslator')
            ->willReturn($parentCategoryRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObject($serviceCategory);

        $expectObject = new ServiceCategory();

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
        $serviceCategory = \Sdk\ServiceCategory\Utils\MockFactory::generateServiceCategoryArray();

        $data =  $serviceCategory['data'];
        $relationships = $data['relationships'];

        $parentCategory = new ParentCategory($relationships['parentCategory']['data']['id']);
        $parentCategoryRestfulTranslator = $this->prophesize(ParentCategoryRestfulTranslator::class);
        $parentCategoryRestfulTranslator->arrayToObject(Argument::exact($relationships['parentCategory']))
            ->shouldBeCalledTimes(1)->willReturn($parentCategory);

        $this->stub->expects($this->exactly(1))
            ->method('getParentCategoryRestfulTranslator')
            ->willReturn($parentCategoryRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($serviceCategory);

        $expectArray = array();

        $expectObject = new ServiceCategory();

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
        $serviceCategory = \Sdk\ServiceCategory\Utils\MockFactory::generateServiceCategoryObject(1, 1);

        $actual = $this->stub->objectToArray($serviceCategory);

        $expectedArray = array(
            'data'=>array(
                'type'=>'serviceCategories'
            )
        );

        $expectedArray['data']['attributes'] = array(
            'name'=>$serviceCategory->getName(),
            'isQualification'=>$serviceCategory->getIsQualification(),
            'qualificationName'=>$serviceCategory->getQualificationName(),
            'commission'=>$serviceCategory->getCommission(),
            'status'=>$serviceCategory->getStatus(),
        );

        $expectedArray['data']['relationships']['parentCategory']['data'] = array(
            array(
                'type' => 'parentCategories',
                'id' => $serviceCategory->getParentCategory()->getId()
            )
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
