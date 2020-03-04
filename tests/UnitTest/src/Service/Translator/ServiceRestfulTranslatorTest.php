<?php
namespace Sdk\Service\Translator;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Translator\EnterpriseRestfulTranslator;
use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;
use Sdk\Service\Model\Service;

class ServiceRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            ServiceRestfulTranslator::class
        )
            ->setMethods([
                'getEnterpriseRestfulTranslator',
                'getServiceCategoryRestfulTranslator',
            ])
            ->getMock();

        $this->childStub =
        new class extends ServiceRestfulTranslator
        {
            public function getEnterpriseRestfulTranslator(): EnterpriseRestfulTranslator
            {
                return parent::getEnterpriseRestfulTranslator();
            }

            public function getServiceCategoryRestfulTranslator(): ServiceCategoryRestfulTranslator
            {
                return parent::getServiceCategoryRestfulTranslator();
            }
        };
    }

    public function testGetEnterpriseRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Enterprise\Translator\EnterpriseRestfulTranslator',
            $this->childStub->getEnterpriseRestfulTranslator()
        );
    }

    public function testGetServiceCategoryRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator',
            $this->childStub->getServiceCategoryRestfulTranslator()
        );
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new Service());
        $this->assertInstanceOf('Sdk\Service\Model\NullService', $result);
    }

    public function setMethods(Service $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['title'])) {
            $expectObject->setTitle($attributes['title']);
        }
        if (isset($attributes['detail'])) {
            $expectObject->setDetail($attributes['detail']);
        }
        if (isset($attributes['cover'])) {
            $expectObject->setCover($attributes['cover']);
        }
        if (isset($attributes['minPrice'])) {
            $expectObject->setMinPrice($attributes['minPrice']);
        }
        if (isset($attributes['price'])) {
            $expectObject->setPrice($attributes['price']);
        }
        if (isset($attributes['maxPrice'])) {
            $expectObject->setMaxPrice($attributes['maxPrice']);
        }
        if (isset($attributes['contract'])) {
            $expectObject->setcontract($attributes['contract']);
        }
        if (isset($attributes['detail'])) {
            $expectObject->setDetail($attributes['detail']);
        }
        if (isset($attributes['volume'])) {
            $expectObject->setVolume($attributes['volume']);
        }
        if (isset($attributes['attentionDegree'])) {
            $expectObject->setAttentionDegree($attributes['attentionDegree']);
        }
        if (isset($attributes['rejectReason'])) {
            $expectObject->setRejectReason($attributes['rejectReason']);
        }
        if (isset($attributes['applyStatus'])) {
            $expectObject->setApplyStatus($attributes['applyStatus']);
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
        if (isset($relationships['enterprise']['data'])) {
            $expectObject->setEnterprise(new Enterprise($relationships['enterprise']['data']['id']));
        }
        if (isset($relationships['serviceCategory']['data'])) {
            $expectObject->setServiceCategory(new ServiceCategory($relationships['serviceCategory']['data']['id']));
        }

        return $expectObject;
    }

    private function establishingPrediction($service, $data, $relationships)
    {
        $enterprise = new Enterprise($relationships['enterprise']['data']['id']);
        $enterpriseRestfulTranslator = $this->prophesize(EnterpriseRestfulTranslator::class);
        $enterpriseRestfulTranslator->arrayToObject(Argument::exact($relationships['enterprise']))
            ->shouldBeCalledTimes(1)->willReturn($enterprise);

        $this->stub->expects($this->exactly(1))
            ->method('getEnterpriseRestfulTranslator')
            ->willReturn($enterpriseRestfulTranslator->reveal());

        $serviceCategory = new ServiceCategory($relationships['serviceCategory']['data']['id']);
        $serviceCategoryRestfulTranslator = $this->prophesize(ServiceCategoryRestfulTranslator::class);
        $serviceCategoryRestfulTranslator->arrayToObject(Argument::exact($relationships['serviceCategory']))
            ->shouldBeCalledTimes(1)->willReturn($serviceCategory);

        $this->stub->expects($this->exactly(1))
            ->method('getServiceCategoryRestfulTranslator')
            ->willReturn($serviceCategoryRestfulTranslator->reveal());
    }

    public function testArrayToObjectCorrectObject()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceArray();

        $data = $service['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($service, $data, $relationships);

        $actual = $this->stub->arrayToObject($service);

        $expectObject = new Service();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->stub->arrayToObjects(array());
        $this->assertEquals(array(0, array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceArray();

        $data = $service['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($service, $data, $relationships);

        $actual = $this->stub->arrayToObjects($service);

        $expectArray = array();

        $expectObject = new Service();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $expectArray = [1, [$data['id'] => $expectObject]];

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
        $service = \Sdk\Service\Utils\MockFactory::generateServiceObject(1, 1);

        $actual = $this->stub->objectToArray($service);

        $expectedArray = array(
            'data' => array(
                'type' => 'services',
            ),
        );

        $expectedArray['data']['attributes'] = array(
            'title' => $service->getTitle(),
            'cover' => $service->getCover(),
            'price' => $service->getPrice(),
            'contract' => $service->getContract(),
            'detail' => $service->getDetail(),
            'serviceObjects' => $service->getServiceObjects(),
            'rejectReason' => $service->getRejectReason(),
        );

        $expectedArray['data']['relationships']['serviceCategory']['data'] = array(
            array(
                'type' => 'serviceCategories',
                'id' => $service->getServiceCategory()->getId(),
            ),
        );

        $expectedArray['data']['relationships']['enterprise']['data'] = array(
            array(
                'type' => 'enterprises',
                'id' => $service->getEnterprise()->getId(),
            ),
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
