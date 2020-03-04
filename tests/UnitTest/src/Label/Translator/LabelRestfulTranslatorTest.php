<?php
namespace Sdk\Label\Translator;

use Sdk\Label\Model\NullLabel;
use Sdk\Label\Model\Label;
use Sdk\Label\Model\IdentityInfo;
use Sdk\Common\Model\IdentifyCard;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Crew\Translator\CrewRestfulTranslator;
use Sdk\Crew\Model\Crew;

class LabelRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            LabelRestfulTranslator::class
        )
            ->setMethods(['getCrewRestfulTranslator'])
            ->getMock();

        $this->childStub =
        new class extends LabelRestfulTranslator {
            public function getCrewRestfulTranslator() : CrewRestfulTranslator
            {
                return parent::getCrewRestfulTranslator();
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

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new Label());
        $this->assertInstanceOf('Sdk\Label\Model\NullLabel', $result);
    }

    public function setMethods(Label $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['name'])) {
            $expectObject->setName($attributes['name']);
        }
        if (isset($attributes['icon'])) {
            $expectObject->setIcon($attributes['icon']);
        }
        if (isset($attributes['category'])) {
            $expectObject->setCategory($attributes['category']);
        }
        if (isset($attributes['remark'])) {
            $expectObject->setRemark($attributes['remark']);
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

        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $label = \Sdk\Label\Utils\MockFactory::generateLabelArray();

        $data =  $label['data'];
        $relationships = $data['relationships'];

        $crew = new Crew($relationships['crew']['data']['id']);
        $crewRestfulTranslator = $this->prophesize(CrewRestfulTranslator::class);
        $crewRestfulTranslator->arrayToObject(Argument::exact($relationships['crew']))
            ->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getCrewRestfulTranslator')
            ->willReturn($crewRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObject($label);

        $expectObject = new Label();

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
        $label = \Sdk\Label\Utils\MockFactory::generateLabelArray();
        $data =  $label['data'];
        $relationships = $data['relationships'];

        $crew = new Crew($relationships['crew']['data']['id']);
        $crewRestfulTranslator = $this->prophesize(CrewRestfulTranslator::class);
        $crewRestfulTranslator->arrayToObject(Argument::exact($relationships['crew']))
            ->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getCrewRestfulTranslator')
            ->willReturn($crewRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($label);

        $expectArray = array();

        $expectObject = new Label();

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
        $label = \Sdk\Label\Utils\MockFactory::generateLabelObject(1, 1);

        $actual = $this->stub->objectToArray($label);

        $expectedArray = array(
            'data'=>array(
                'type'=>'labels',
                'id'=>$label->getId()
            )
        );

        $expectedArray['data']['attributes'] = array(
            'name'=>$label->getName(),
            'icon'=>$label->getIcon(),
            'category'=>$label->getCategory(),
            'remark'=>$label->getRemark(),
        );

        $expectedArray['data']['relationships']['crew']['data'] = array(
            array(
                'type' => 'crews',
                'id' => $label->getCrew()->getId()
            )
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
