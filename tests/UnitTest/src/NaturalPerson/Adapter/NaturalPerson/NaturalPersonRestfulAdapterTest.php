<?php
namespace Sdk\NaturalPerson\Adapter\NaturalPerson;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\NaturalPerson\Model\NaturalPerson;
use Sdk\NaturalPerson\Model\NullNaturalPerson;
use Sdk\NaturalPerson\Utils\MockFactory;
use Sdk\NaturalPerson\Translator\NaturalPersonRestfulTranslator;

class NaturalPersonRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(NaturalPersonRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends NaturalPersonRestfulAdapter {
            public function getResource() : string
            {
                return parent::getResource();
            }

            public function getTranslator() : IRestfulTranslator
            {
                return parent::getTranslator();
            }

            public function getScenario() : array
            {
                return parent::getScenario();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testImplementsINaturalPersonAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\NaturalPerson\Adapter\NaturalPerson\INaturalPersonAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('naturalPersons', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\NaturalPerson\Translator\NaturalPersonRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }

    /**
     * 循环测试 scenario() 是否符合预定范围
     *
     * @dataProvider scenarioDataProvider
     */
    public function testScenario($expect, $actual)
    {
        $this->childStub->scenario($expect);
        $this->assertEquals($actual, $this->childStub->getScenario());
    }
     /**
     * 循环测试 testScenario() 数据构建器
     */
    public function scenarioDataProvider()
    {
        return [
            [
                'NATURALPERSON_LIST',
                NaturalPersonRestfulAdapter::SCENARIOS['NATURALPERSON_LIST']
            ],
            [
                'NATURALPERSON_FETCH_ONE',
                NaturalPersonRestfulAdapter::SCENARIOS['NATURALPERSON_FETCH_ONE']
            ],
            ['NULL', array()]
        ];
    }
    /**
     * 设置ID
     * 根据ID生成模拟数据
     * 揭示fetchOneAction，期望返回模拟的数据
     * 执行fetchOne（）方法
     * 判断result是否和模拟数据相等，不相等则抛出异常
     */
    public function testFetchOne()
    {
        $id = 1;

        $NaturalPerson = MockFactory::generateNaturalPersonObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullNaturalPerson())
            ->willReturn($NaturalPerson);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($NaturalPerson, $result);
    }
    /**
     * 为NaturalPersonRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$NaturalPerson，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareNaturalPersonTranslator(
        NaturalPerson $NaturalPerson,
        array $keys,
        array $NaturalPersonArray
    ) {
        $translator = $this->prophesize(NaturalPersonRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($NaturalPerson),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($NaturalPersonArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(NaturalPerson $NaturalPerson)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($NaturalPerson);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareNaturalPersonTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $NaturalPerson = MockFactory::generateNaturalPersonObject(1);
        $NaturalPersonArray = array('bindCompanies');

        $this->prepareNaturalPersonTranslator(
            $NaturalPerson,
            array(
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto',
                'member'
            ),
            $NaturalPersonArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('naturalPersons', $NaturalPersonArray);

        $this->success($NaturalPerson);

        $result = $this->stub->add($NaturalPerson);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareNaturalPersonTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $NaturalPerson = MockFactory::generateNaturalPersonObject(1);
        $NaturalPersonArray = array('NaturalPersons');

        $this->prepareNaturalPersonTranslator(
            $NaturalPerson,
            array(
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto',
                'member'
            ),
            $NaturalPersonArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('naturalPersons', $NaturalPersonArray);

        $this->failure($NaturalPerson);
        $result = $this->stub->add($NaturalPerson);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareNaturalPersonTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $NaturalPerson = MockFactory::generateNaturalPersonObject(1);
        $NaturalPersonArray = array('NaturalPersons');

        $this->prepareNaturalPersonTranslator(
            $NaturalPerson,
            array(
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto',
            ),
            $NaturalPersonArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'naturalPersons/'.$NaturalPerson->getId().'/resubmit',
                $NaturalPersonArray
            );

        $this->success($NaturalPerson);

        $result = $this->stub->edit($NaturalPerson);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareNaturalPersonTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $NaturalPerson = MockFactory::generateNaturalPersonObject(1);
        $NaturalPersonArray = array('NaturalPersons');

        $this->prepareNaturalPersonTranslator(
            $NaturalPerson,
            array(
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto',
            ),
            $NaturalPersonArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'naturalPersons/'.$NaturalPerson->getId().'/resubmit',
                $NaturalPersonArray
            );

        $this->failure($NaturalPerson);
        $result = $this->stub->edit($NaturalPerson);
        $this->assertFalse($result);
    }
}
