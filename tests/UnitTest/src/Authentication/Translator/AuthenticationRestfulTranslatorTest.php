<?php
namespace Sdk\Authentication\Translator;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sdk\Authentication\Model\Authentication;
use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Translator\EnterpriseRestfulTranslator;
use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

class AuthenticationRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            AuthenticationRestfulTranslator::class
        )
            ->setMethods([
                'getEnterpriseRestfulTranslator',
                'getQualificationRestfulTranslator',
                'getServiceCategoryRestfulTranslator',
            ])
            ->getMock();

        $this->childStub =
        new class extends AuthenticationRestfulTranslator
        {
            public function getEnterpriseRestfulTranslator(): EnterpriseRestfulTranslator
            {
                return parent::getEnterpriseRestfulTranslator();
            }
            public function getQualificationRestfulTranslator(): QualificationRestfulTranslator
            {
                return parent::getQualificationRestfulTranslator();
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

    public function testGetQualificationRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Authentication\Translator\QualificationRestfulTranslator',
            $this->childStub->getQualificationRestfulTranslator()
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
        $result = $this->stub->arrayToObject(array(), new Authentication());
        $this->assertInstanceOf('Sdk\Authentication\Model\NullAuthentication', $result);
    }

    public function setMethods(Authentication $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['enterpriseName'])) {
            $expectObject->setEnterpriseName($attributes['enterpriseName']);
        }
        if (isset($attributes['qualificationImage'])) {
            $expectObject->setQualificationImage($attributes['qualificationImage']);
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
        if (isset($relationships['serviceCategory']['data'])) {
            $expectObject->setServiceCategory(new ServiceCategory($relationships['serviceCategory']['data']['id']));
        }
        if (isset($relationships['enterprise']['data'])) {
            $expectObject->setEnterprise(new Enterprise($relationships['enterprise']['data']['id']));
        }

        return $expectObject;
    }

    private function establishingPrediction($authentication, $data, $relationships)
    {
        $serviceCategory = new ServiceCategory($relationships['serviceCategory']['data']['id']);
        $serviceCategoryRestfulTranslator = $this->prophesize(ServiceCategoryRestfulTranslator::class);
        $serviceCategoryRestfulTranslator->arrayToObject(Argument::exact($relationships['serviceCategory']))
            ->shouldBeCalledTimes(1)->willReturn($serviceCategory);

        $this->stub->expects($this->exactly(1))
            ->method('getServiceCategoryRestfulTranslator')
            ->willReturn($serviceCategoryRestfulTranslator->reveal());

        $enterprise = new Enterprise($relationships['enterprise']['data']['id']);
        $enterpriseRestfulTranslator = $this->prophesize(EnterpriseRestfulTranslator::class);
        $enterpriseRestfulTranslator->arrayToObject(Argument::exact($relationships['enterprise']))
            ->shouldBeCalledTimes(1)->willReturn($enterprise);

        $this->stub->expects($this->exactly(1))
            ->method('getEnterpriseRestfulTranslator')
            ->willReturn($enterpriseRestfulTranslator->reveal());
    }

    public function testArrayToObjectCorrectObject()
    {
        $authentication = \Sdk\Authentication\Utils\MockFactory::generateAuthenticationArray();

        $data = $authentication['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($authentication, $data, $relationships);

        $actual = $this->stub->arrayToObject($authentication);

        $expectObject = new Authentication();

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
        $authentication = \Sdk\Authentication\Utils\MockFactory::generateAuthenticationArray();

        $data = $authentication['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($authentication, $data, $relationships);

        $actual = $this->stub->arrayToObjects($authentication);

        $expectArray = array();

        $expectObject = new Authentication();

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
        $authentication = \Sdk\Authentication\Utils\MockFactory::generateAuthenticationObject(1, 1);

        $actual = $this->stub->objectToArray($authentication);

        $expectedArray = array(
            'data' => array(
                'type' => 'authentications',
            ),
        );

        $expectedArray['data']['attributes'] = array(
            'enterpriseName' => $authentication->getEnterpriseName(),
            'qualificationImage' => $authentication->getQualificationImage(),
            'rejectReason' => $authentication->getRejectReason(),
        );

        $expectedArray['data']['relationships']['qualifications']['data'] = array(
        );

        $expectedArray['data']['relationships']['enterprise']['data'] = array(
            array(
                'type' => 'enterprises',
                'id' => $authentication->getEnterprise()->getId(),
            ),
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
