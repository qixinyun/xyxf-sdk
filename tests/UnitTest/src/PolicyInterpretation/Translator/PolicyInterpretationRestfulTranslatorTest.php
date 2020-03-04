<?php
namespace Sdk\PolicyInterpretation\Translator;

use Sdk\PolicyInterpretation\Model\NullPolicyInterpretation;
use Sdk\PolicyInterpretation\Model\PolicyInterpretation;
use Sdk\PolicyInterpretation\Model\IdentityInfo;
use Sdk\Common\Model\IdentifyCard;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Crew\Translator\CrewRestfulTranslator;
use Sdk\Policy\Translator\PolicyRestfulTranslator;
use Sdk\Crew\Model\Crew;
use Sdk\Policy\Model\Policy;

class PolicyInterpretationRestfulTranslatorTest extends TestCase
{

    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyInterpretationRestfulTranslator::class)
                ->setMethods([
                    'getCrewRestfulTranslator',
                    'getPolicyRestfulTranslator'
                ])
                ->getMock();

        $this->childStub = new class extends PolicyInterpretationRestfulTranslator {
            public function getCrewRestfulTranslator() : CrewRestfulTranslator
            {
                return parent::getCrewRestfulTranslator();
            }

            public function getPolicyRestfulTranslator() : PolicyRestfulTranslator
            {
                return parent::getPolicyRestfulTranslator();
            }
        };
    }

    public function testGetCrewRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Crew\Translator\CrewRestfulTranslator',
            $this->childStub->getCrewRestfulTranslator()
        );
    }

    public function testGetPolicyRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Policy\Translator\PolicyRestfulTranslator',
            $this->childStub->getPolicyRestfulTranslator()
        );
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new PolicyInterpretation());
        $this->assertInstanceOf('Sdk\PolicyInterpretation\Model\NullPolicyInterpretation', $result);
    }

    private function setMethods(PolicyInterpretation $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['cover'])) {
            $expectObject->setCover($attributes['cover']);
        }
        if (isset($attributes['title'])) {
            $expectObject->setTitle($attributes['title']);
        }
        if (isset($attributes['detail'])) {
            $expectObject->setDetail($attributes['detail']);
        }
        if (isset($attributes['description'])) {
            $expectObject->setDescription($attributes['description']);
        }
        if (isset($attributes['attachments'])) {
            $expectObject->setAttachments($attributes['attachments']);
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
        if (isset($relationships['crew']['data'])) {
            $expectObject->setCrew(new Crew($relationships['crew']['data']['id']));
        }
        if (isset($relationships['policy']['data'])) {
            $expectObject->setPolicy(new Policy($relationships['policy']['data']['id']));
        }

        return $expectObject;
    }

    private function prepareCrewAndPolicy($relationships)
    {
        $crew = new Crew($relationships['crew']['data']['id']);
        $crewRestfulTranslator = $this->prophesize(CrewRestfulTranslator::class);
        $crewRestfulTranslator->arrayToObject(Argument::exact($relationships['crew']))
            ->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getCrewRestfulTranslator')
            ->willReturn($crewRestfulTranslator->reveal());

        $policy = new Policy($relationships['policy']['data']['id']);
        $policyRestfulTranslator = $this->prophesize(PolicyRestfulTranslator::class);
        $policyRestfulTranslator->arrayToObject(Argument::exact($relationships['policy']))
            ->shouldBeCalledTimes(1)->willReturn($policy);

        $this->stub->expects($this->exactly(1))
            ->method('getPolicyRestfulTranslator')
            ->willReturn($policyRestfulTranslator->reveal());
    }

    public function testArrayToObjectCorrectObject()
    {
        $policyInterpretation = \Sdk\PolicyInterpretation\Utils\MockFactory::generatePolicyInterpretationArray();

        $data =  $policyInterpretation['data'];
        $relationships = $data['relationships'];

        $this->prepareCrewAndPolicy($relationships);

        $actual = $this->stub->arrayToObject($policyInterpretation);

        $expectObject = new PolicyInterpretation();

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
        $policyInterpretation = \Sdk\PolicyInterpretation\Utils\MockFactory::generatePolicyInterpretationArray();
        $data =  $policyInterpretation['data'];
        $relationships = $data['relationships'];

        $this->prepareCrewAndPolicy($relationships);

        $actual = $this->stub->arrayToObjects($policyInterpretation);

        $expectArray = array();

        $expectObject = new PolicyInterpretation();

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
        $policyInterpretation = \Sdk\PolicyInterpretation\Utils\MockFactory::generatePolicyInterpretationObject(1, 1);

        $actual = $this->stub->objectToArray($policyInterpretation);

        $expectedArray = array(
            'data'=>array(
                'type'=>'policyInterpretations'
            )
        );

        $expectedArray['data']['attributes'] = array(
            'cover'=>$policyInterpretation->getCover(),
            'title'=>$policyInterpretation->getTitle(),
            'detail'=>$policyInterpretation->getDetail(),
            'description'=>$policyInterpretation->getDescription(),
            'attachments'=>$policyInterpretation->getAttachments()
        );

        $expectedArray['data']['relationships']['crew']['data'] = array(
            array(
                'type' => 'crews',
                'id' => $policyInterpretation->getCrew()->getId()
            )
        );
        $expectedArray['data']['relationships']['policy']['data'] = array(
            array(
                'type' => 'policies',
                'id' => $policyInterpretation->getPolicy()->getId()
            )
        );
        
        $this->assertEquals($expectedArray, $actual);
    }
}
