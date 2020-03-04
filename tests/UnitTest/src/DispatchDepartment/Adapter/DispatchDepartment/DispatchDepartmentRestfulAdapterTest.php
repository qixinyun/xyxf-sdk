<?php
namespace Sdk\DispatchDepartment\Adapter\DispatchDepartment;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\DispatchDepartment\Model\DispatchDepartment;
use Sdk\DispatchDepartment\Model\NullDispatchDepartment;
use Sdk\DispatchDepartment\Utils\MockFactory;
use Sdk\DispatchDepartment\Translator\DispatchDepartmentRestfulTranslator;

class DispatchDepartmentRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DispatchDepartmentRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends DispatchDepartmentRestfulAdapter {
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

    public function testImplementsIDispatchDepartmentAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\DispatchDepartment\Adapter\DispatchDepartment\IDispatchDepartmentAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('dispatchDepartments', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\DispatchDepartment\Translator\DispatchDepartmentRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }

    /**
     * @dataProvider scenarioDataProvider
     */
    public function testScenario($expect, $actual)
    {
        $this->childStub->scenario($expect);
        $this->assertEquals($actual, $this->childStub->getScenario());
    }

    public function scenarioDataProvider()
    {
        return [
            [
                'DISPATCHDEPARTMENT_LIST',
                DispatchDepartmentRestfulAdapter::SCENARIOS['DISPATCHDEPARTMENT_LIST']
            ],
            [
                'DISPATCHDEPARTMENT_FETCH_ONE',
                DispatchDepartmentRestfulAdapter::SCENARIOS['DISPATCHDEPARTMENT_FETCH_ONE']
            ],
            ['NULL', array()]
        ];
    }

    public function testFetchOne()
    {
        $id = 1;

        $dispatchDepartment = MockFactory::generateDispatchDepartmentObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullDispatchDepartment())
            ->willReturn($dispatchDepartment);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($dispatchDepartment, $result);
    }

    private function prepareDispatchDepartmentTranslator(
        DispatchDepartment $dispatchDepartment,
        array $keys,
        array $dispatchDepartmentArray
    ) {
        $translator = $this->prophesize(DispatchDepartmentRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($dispatchDepartment),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($dispatchDepartmentArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(DispatchDepartment $dispatchDepartment)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($dispatchDepartment);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }

    public function testAddSuccess()
    {
        $dispatchDepartment = MockFactory::generateDispatchDepartmentObject(1);
        $dispatchDepartmentArray = array();

        $this->prepareDispatchDepartmentTranslator(
            $dispatchDepartment,
            array(
                'name',
                'remark',
                'status',
                'crew'
            ),
            $dispatchDepartmentArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('dispatchDepartments', $dispatchDepartmentArray);

        $this->success($dispatchDepartment);

        $result = $this->stub->add($dispatchDepartment);
        $this->assertTrue($result);
    }

    public function testAddFailure()
    {
        $dispatchDepartment = MockFactory::generateDispatchDepartmentObject(1);
        $dispatchDepartmentArray = array();

        $this->prepareDispatchDepartmentTranslator(
            $dispatchDepartment,
            array(
                'name',
                'remark',
                'status',
                'crew'
            ),
            $dispatchDepartmentArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('dispatchDepartments', $dispatchDepartmentArray);

        $this->failure($dispatchDepartment);
        $result = $this->stub->add($dispatchDepartment);
        $this->assertFalse($result);
    }

    public function testEditSuccess()
    {
        $dispatchDepartment = MockFactory::generateDispatchDepartmentObject(1);
        $dispatchDepartmentArray = array();

        $this->prepareDispatchDepartmentTranslator(
            $dispatchDepartment,
            array(
                'name',
                'remark',
                'status'
            ),
            $dispatchDepartmentArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'dispatchDepartments/'.$dispatchDepartment->getId(),
                $dispatchDepartmentArray
            );

        $this->success($dispatchDepartment);

        $result = $this->stub->edit($dispatchDepartment);
        $this->assertTrue($result);
    }

    public function testEditFailure()
    {
        $dispatchDepartment = MockFactory::generateDispatchDepartmentObject(1);
        $dispatchDepartmentArray = array();

        $this->prepareDispatchDepartmentTranslator(
            $dispatchDepartment,
            array(
                'name',
                'remark',
                'status'
            ),
            $dispatchDepartmentArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'dispatchDepartments/'.$dispatchDepartment->getId(),
                $dispatchDepartmentArray
            );

        $this->failure($dispatchDepartment);
        $result = $this->stub->edit($dispatchDepartment);
        $this->assertFalse($result);
    }
}
