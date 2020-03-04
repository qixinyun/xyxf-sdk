<?php
namespace Sdk\Crew\Adapter\Crew;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Crew\Model\Crew;
use Sdk\Crew\Model\NullCrew;
use Sdk\Crew\Utils\MockFactory;
use Sdk\Crew\Translator\CrewRestfulTranslator;

class CrewRestfulAdapterTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(CrewRestfulAdapter::class)
            ->setMethods(
                ['fetchOneAction','isSuccess','post','patch','translateToObject','getTranslator']
            )->getMock();

        $this->childStub = new class extends CrewRestfulAdapter
        {
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

    public function testImplementsICrewAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Crew\Adapter\Crew\ICrewAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('crews', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Crew\Translator\CrewRestfulTranslator',
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
            ['CREW_LIST', CrewRestfulAdapter::SCENARIOS['CREW_LIST']],
            ['CREW_FETCH_ONE', CrewRestfulAdapter::SCENARIOS['CREW_FETCH_ONE']],
            ['NULL', array()]
        ];
    }

    public function testFetchOne()
    {
        $id = 1;

        $crew = MockFactory::generateCrewObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullCrew())
            ->willReturn($crew);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($crew, $result);
    }

    private function prepareCrewTranslator(Crew $crew, array $keys, array $crewArray)
    {
        $translator = $this->prophesize(CrewRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($crew),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($crewArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Crew $crew)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($crew);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }

    public function testSignInFailure()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->prepareCrewTranslator(
            $crew,
            array('cellphone', 'password'),
            $crewArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('crews/signIn', $crewArray);

        $this->failure($crew);
        $result = $this->stub->signIn($crew);
        $this->assertFalse($result);
    }

    public function testUpdatePasswordSuccess()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->preparecrewTranslator(
            $crew,
            array('oldPassword', 'password'),
            $crewArray
        );

        $this->stub
            ->method('patch')
            ->with('crews/'.$crew->getId().'/updatePassword', $crewArray);

        $this->success($crew);
        $result = $this->stub->updatePassword($crew);
        $this->assertTrue($result);
    }

    public function testUpdatePasswordFailure()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->prepareCrewTranslator(
            $crew,
            array('oldPassword', 'password'),
            $crewArray
        );

        $this->stub
            ->method('patch')
            ->with('crews/'.$crew->getId().'/updatePassword', $crewArray);

        $this->failure($crew);
        $result = $this->stub->updatePassword($crew);
        $this->assertFalse($result);
    }

    public function testAddSuccess()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->preparecrewTranslator(
            $crew,
            array('realName', 'avatar', 'gender'),
            $crewArray
        );

        $this->stub
            ->method('post')
            ->with('crews', $crewArray);

        $this->success($crew);
        $result = $this->stub->add($crew);
        $this->assertTrue($result);
    }

    public function testAddFailure()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->prepareCrewTranslator(
            $crew,
            array('realName', 'avatar', 'gender'),
            $crewArray
        );

        $this->stub
            ->method('post')
            ->with('crews', $crewArray);

        $this->failure($crew);
        $result = $this->stub->add($crew);
        $this->assertFalse($result);
    }

    public function testEditSuccess()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->preparecrewTranslator(
            $crew,
            array('realName', 'avatar', 'gender'),
            $crewArray
        );

        $this->stub
            ->method('patch')
            ->with('crews/'.$crew->getId(), $crewArray);

        $this->success($crew);
        $result = $this->stub->edit($crew);
        $this->assertTrue($result);
    }

    public function testEditFailure()
    {
        $crew = MockFactory::generateCrewObject(1);
        $crewArray = array('crews');

        $this->prepareCrewTranslator(
            $crew,
            array('realName', 'avatar', 'gender'),
            $crewArray
        );

        $this->stub
            ->method('patch')
            ->with('crews/'.$crew->getId(), $crewArray);

        $this->failure($crew);
        $result = $this->stub->edit($crew);
        $this->assertFalse($result);
    }
}
