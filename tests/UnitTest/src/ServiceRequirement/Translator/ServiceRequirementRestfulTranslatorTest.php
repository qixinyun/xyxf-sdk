<?php
namespace Sdk\ServiceRequirement\Translator;

use Sdk\ServiceRequirement\Model\NullServiceRequirement;
use Sdk\ServiceRequirement\Model\ServiceRequirement;
use Sdk\ServiceRequirement\Model\IdentityInfo;
use Sdk\Common\Model\IdentifyCard;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Member\Translator\MemberRestfulTranslator;
use Sdk\Member\Model\Member;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;
use Sdk\ServiceCategory\Model\ServiceCategory;

class ServiceRequirementRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            ServiceRequirementRestfulTranslator::class
        )
            ->setMethods([
                'getMemberRestfulTranslator',
                'getServiceCategoryRestfulTranslator'
            ])
            ->getMock();

        $this->childStub =
        new class extends ServiceRequirementRestfulTranslator {
            public function getMemberRestfulTranslator() : MemberRestfulTranslator
            {
                return parent::getMemberRestfulTranslator();
            }

            public function getServiceCategoryRestfulTranslator() : ServiceCategoryRestfulTranslator
            {
                return parent::getServiceCategoryRestfulTranslator();
            }
        };
    }

    public function testGetMemberRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Member\Translator\MemberRestfulTranslator',
            $this->childStub->getMemberRestfulTranslator()
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
        $result = $this->stub->arrayToObject(array(), new ServiceRequirement());
        $this->assertInstanceOf('Sdk\ServiceRequirement\Model\NullServiceRequirement', $result);
    }

    public function setMethods(ServiceRequirement $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['title'])) {
            $expectObject->setTitle($attributes['title']);
        }
        if (isset($attributes['detail'])) {
            $expectObject->setDetail($attributes['detail']);
        }
        if (isset($attributes['minPrice'])) {
            $expectObject->setMinPrice($attributes['minPrice']);
        }
        if (isset($attributes['maxPrice'])) {
            $expectObject->setMaxPrice($attributes['maxPrice']);
        }
        if (isset($attributes['validityStartTime'])) {
            $expectObject->setValidityStartTime($attributes['validityStartTime']);
        }
        if (isset($attributes['validityEndTime'])) {
            $expectObject->setValidityEndTime($attributes['validityEndTime']);
        }
        if (isset($attributes['contactName'])) {
            $expectObject->setContactName($attributes['contactName']);
        }
        if (isset($attributes['contactPhone'])) {
            $expectObject->setContactPhone($attributes['contactPhone']);
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
        if (isset($relationships['member']['data'])) {
            $expectObject->setMember(new Member($relationships['member']['data']['id']));
        }
        if (isset($relationships['serviceCategory']['data'])) {
            $expectObject->setServiceCategory(new ServiceCategory($relationships['serviceCategory']['data']['id']));
        }

        return $expectObject;
    }

    private function establishingPrediction($serviceRequirement, $data, $relationships)
    {
        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

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
        $serviceRequirement = \Sdk\ServiceRequirement\Utils\MockFactory::generateServiceRequirementArray();

        $data = $serviceRequirement['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($serviceRequirement, $data, $relationships);

        $actual = $this->stub->arrayToObject($serviceRequirement);

        $expectObject = new ServiceRequirement();

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
        $serviceRequirement = \Sdk\ServiceRequirement\Utils\MockFactory::generateServiceRequirementArray();

        $data = $serviceRequirement['data'];
        $relationships = $data['relationships'];
        $this->establishingPrediction($serviceRequirement, $data, $relationships);

        $actual = $this->stub->arrayToObjects($serviceRequirement);

        $expectArray = array();

        $expectObject = new ServiceRequirement();

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
        $serviceRequirement = \Sdk\ServiceRequirement\Utils\MockFactory::generateServiceRequirementObject(1, 1);

        $actual = $this->stub->objectToArray($serviceRequirement);

        $expectedArray = array(
            'data' => array(
                'type' => 'serviceRequirements',
            ),
        );

        $expectedArray['data']['attributes'] = array(
            'title' => $serviceRequirement->getTitle(),
            'detail' => $serviceRequirement->getDetail(),
            'minPrice' => $serviceRequirement->getMinPrice(),
            'maxPrice' => $serviceRequirement->getMaxPrice(),
            'validityStartTime' => $serviceRequirement->getValidityStartTime(),
            'validityEndTime' => $serviceRequirement->getValidityEndTime(),
            'contactName' => $serviceRequirement->getContactName(),
            'contactPhone' => $serviceRequirement->getContactPhone(),
            'rejectReason' => $serviceRequirement->getRejectReason(),
        );

        $expectedArray['data']['relationships']['serviceCategory']['data'] = array(
            array(
                'type' => 'serviceCategories',
                'id' => $serviceRequirement->getServiceCategory()->getId(),
            ),
        );

        $expectedArray['data']['relationships']['member']['data'] = array(
            array(
                'type' => 'members',
                'id' => $serviceRequirement->getMember()->getId(),
            ),
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
