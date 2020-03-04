<?php
namespace Sdk\Policy\Translator;

use Sdk\Policy\Model\NullPolicy;
use Sdk\Policy\Model\Policy;
use Sdk\Policy\Model\IdentityInfo;
use Sdk\Common\Model\IdentifyCard;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Crew\Translator\CrewRestfulTranslator;
use Sdk\DispatchDepartment\Translator\DispatchDepartmentRestfulTranslator;
use Sdk\Label\Translator\LabelRestfulTranslator;
use Sdk\Policy\Model\PolicyModelFactory;
use Sdk\Crew\Model\Crew;
use Sdk\Label\Model\Label;
use Sdk\DispatchDepartment\Model\DispatchDepartment;

class PolicyRestfulTranslatorTest extends TestCase
{

    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyRestfulTranslator::class)
                ->setMethods([
                    'getCrewRestfulTranslator',
                    'getDispatchDepartmentRestfulTranslator',
                    'getLabelRestfulTranslator'
                ])
                ->getMock();

        $this->childStub = new class extends PolicyRestfulTranslator {
            public function getCrewRestfulTranslator() : CrewRestfulTranslator
            {
                return parent::getCrewRestfulTranslator();
            }

            public function getDispatchDepartmentRestfulTranslator() : DispatchDepartmentRestfulTranslator
            {
                return parent::getDispatchDepartmentRestfulTranslator();
            }

            public function getLabelRestfulTranslator() : LabelRestfulTranslator
            {
                return parent::getLabelRestfulTranslator();
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

    public function testGetDispatchDepartmentRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\DispatchDepartment\Translator\DispatchDepartmentRestfulTranslator',
            $this->childStub->getDispatchDepartmentRestfulTranslator()
        );
    }

    public function testGetLabelRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Label\Translator\LabelRestfulTranslator',
            $this->childStub->getLabelRestfulTranslator()
        );
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new Policy());
        $this->assertInstanceOf('Sdk\Policy\Model\NullPolicy', $result);
    }

    private function setMethods(Policy $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['title'])) {
            $expectObject->setTitle($attributes['title']);
        }
        if (isset($attributes['number'])) {
            $expectObject->setNumber($attributes['number']);
        }
        if (isset($attributes['applicableObjects'])) {
            foreach ($attributes['applicableObjects'] as $applicableObjectsId) {
                $applicableObjects[] = PolicyModelFactory::create(
                    $applicableObjectsId,
                    PolicyModelFactory::TYPE['POLICY_APPLICABLE_OBJECT']
                );
            }
            $expectObject->setApplicableObjects($applicableObjects);
        }
        if (isset($attributes['applicableIndustries'])) {
            foreach ($attributes['applicableIndustries'] as $applicableIndustriesId) {
                $applicableIndustries[] = PolicyModelFactory::create(
                    $applicableIndustriesId,
                    PolicyModelFactory::TYPE['POLICY_APPLICABLELNDUSTRIES']
                );
            }
            $expectObject->setApplicableIndustries($applicableIndustries);
        }
        /*if (isset($attributes['level'])) {
            $expectObject->setLevel(PolicyModelFactory::create(
                $attributes['level'],
                PolicyModelFactory::TYPE['POLICY_LEVEL']
            ));
        }*/
        if (isset($attributes['classifies'])) {
            foreach ($attributes['classifies'] as $classifiesId) {
                $classifies[] = PolicyModelFactory::create(
                    $classifiesId,
                    PolicyModelFactory::TYPE['POLICY_CLASSIFY']
                );
            }
            $expectObject->setClassifies($classifies);
        }
        if (isset($attributes['detail'])) {
            $expectObject->setDetail($attributes['detail']);
        }
        if (isset($attributes['description'])) {
            $expectObject->setDescription($attributes['description']);
        }
        if (isset($attributes['image'])) {
            $expectObject->setImage($attributes['image']);
        }
        if (isset($attributes['attachments'])) {
            $expectObject->setAttachments($attributes['attachments']);
        }
        if (isset($attributes['admissibleAddress'])) {
            $expectObject->setAdmissibleAddress($attributes['admissibleAddress']);
        }
        if (isset($attributes['processingFlow'])) {
            $expectObject->setProcessingFlow($attributes['processingFlow']);
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
        /*if (isset($relationships['dispatchDepartment']['data'])) {
            foreach ($relationships['dispatchDepartment']['data'] as $dispatchDepartmentsKey) {
                $relationship['data'] = $relationships;
                $dispatchDepartments = $this->changeArrayFormat($dispatchDepartmentsKey);
                $dispatchDepartmentsObject = $this ->getDispatchDepartmentRestfulTranslator()
                                                   ->arrayToObject($dispatchDepartments);
                $dispatchDepartmentsArray[] = $dispatchDepartmentsObject;
            }
            $expectObject->addDispatchDepartments($dispatchDepartmentsArray);
        }
        if (isset($relationships['label']['data'])) {
            foreach ($relationships['label']['data'] as $labelsKey) {
                $labels = $this->changeArrayFormat($labelsKey);
                $labelsObject = $this->getLabelRestfulTranslator()->arrayToObject($labels);
                $labelsArray[] = $labelsObject;
            }
            $expectObject->addLabels($labelsArray);
        }*/

        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $policy = \Sdk\Policy\Utils\MockFactory::generatePolicyArray();

        $data =  $policy['data'];
        $relationships = $data['relationships'];

        $crew = new Crew($relationships['crew']['data']['id']);
        $crewRestfulTranslator = $this->prophesize(CrewRestfulTranslator::class);
        $crewRestfulTranslator->arrayToObject(Argument::exact($relationships['crew']))
            ->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getCrewRestfulTranslator')
            ->willReturn($crewRestfulTranslator->reveal());

        /*foreach ($relationships['dispatchDepartment']['data'] as $dispatchDepartmentKey)
        {
            $dispatchDepartment = new DispatchDepartment($dispatchDepartmentKey['id']);
            $dispatchDepartmentRestfulTranslator = $this->prophesize(DispatchDepartmentRestfulTranslator::class);
            $dispatchDepartmentRestfulTranslator->arrayToObject(Argument::exact($relationships['dispatchDepartment']))
                ->shouldBeCalledTimes(1)->willReturn($dispatchDepartment);
        }

        $this->stub->expects($this->any())
            ->method('getDispatchDepartmentRestfulTranslator')
            ->willReturn($dispatchDepartmentRestfulTranslator->reveal());

        foreach ($relationships['label']['data'] as $labelKey)
        {
            $label = new Label($labelKey['id']);
            $labelRestfulTranslator = $this->prophesize(LabelRestfulTranslator::class);
            $labelRestfulTranslator->arrayToObject(Argument::exact($relationships['label']))
                ->shouldBeCalledTimes(1)->willReturn($label);
        }

        $this->stub->expects($this->any())
            ->method('getLabelRestfulTranslator')
            ->willReturn($labelRestfulTranslator->reveal());*/

        $actual = $this->stub->arrayToObject($policy);

        $expectObject = new Policy();

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
        $policy = \Sdk\Policy\Utils\MockFactory::generatePolicyArray();
        $data =  $policy['data'];
        $relationships = $data['relationships'];

        $crew = new Crew($relationships['crew']['data']['id']);
        $crewRestfulTranslator = $this->prophesize(CrewRestfulTranslator::class);
        $crewRestfulTranslator->arrayToObject(Argument::exact($relationships['crew']))
            ->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getCrewRestfulTranslator')
            ->willReturn($crewRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($policy);

        $expectArray = array();

        $expectObject = new Policy();

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
        $policy = \Sdk\Policy\Utils\MockFactory::generatePolicyObject(1, 1);

        $actual = $this->stub->objectToArray($policy, array(
                'id',
                'title',
                'number',
                'applicableObjects',
                'applicableIndustries',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'processingFlow',
                'admissibleAddress',
                'crew'
            ));

        $expectedArray = array(
            'data'=>array(
                'type'=>'policies',
                'id'=>$policy->getId()
            )
        );

        $expectedArray['data']['attributes'] = array(
            'title'=>$policy->getTitle(),
            'number'=>$policy->getNumber(),
            'applicableObjects'=>$policy->getApplicableObjects(),
            'applicableIndustries'=>$policy->getApplicableIndustries(),
            'classifies'=>$policy->getClassifies(),
            'detail'=>$policy->getDetail(),
            'description'=>$policy->getDescription(),
            'image'=>$policy->getImage(),
            'attachments'=>$policy->getAttachments(),
            'admissibleAddress'=>$policy->getAdmissibleAddress(),
            'processingFlow'=>$policy->getProcessingFlow()
        );

        $expectedArray['data']['relationships']['crew']['data'] = array(
            array(
                'type' => 'crews',
                'id' => $policy->getCrew()->getId()
            )
        );
        
        $this->assertEquals($expectedArray, $actual);
    }
}
