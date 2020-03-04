<?php
namespace Sdk\Crew\Translator;

use Sdk\Crew\Model\Crew;

use PHPUnit\Framework\TestCase;

use Sdk\User\Translator\UserRestfulTranslatorTest;

class CrewRestfulTranslatorTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new CrewRestfulTranslator();

        parent::setUp();
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new Crew());
        $this->assertInstanceOf('Sdk\Crew\Model\NullCrew', $result);
    }

    private function setMethods(Crew $expectObject, array $attributes)
    {
        if (isset($attributes['workNumber'])) {
            $expectObject->setWorkNumber($attributes['workNumber']);
        }
        $user = new UserRestfulTranslatorTest();
        $expectObject = $user->setMethods($expectObject, $attributes);

        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $crew = \Sdk\Crew\Utils\MockFactory::generateCrewArray();
        
        $data =  $crew['data'];

        $actual = $this->stub->arrayToObject($crew);

        $expectObject = new Crew();

        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];

        $expectObject = $this->setMethods($expectObject, $attributes);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->stub->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $crew = \Sdk\Crew\Utils\MockFactory::generateCrewArray();
        
        $data =  $crew['data'];

        $actual = $this->stub->arrayToObjects($crew);

        $crewArray = array();

        $expectObject = new Crew();

        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];

        $expectObject = $this->setMethods($expectObject, $attributes);

        $crewArray = [1, [$data['id']=>$expectObject]];

        $this->assertEquals($crewArray, $actual);
    }

    public function testArrayToObjectsCorrectObject()
    {
        $crew[] = \Sdk\Crew\Utils\MockFactory::generateCrewArray(1);
        $crew[] = \Sdk\Crew\Utils\MockFactory::generateCrewArray(2);

        $crewArray = array(
            'data'=>array(
                $crew[0]['data'],
                $crew[1]['data']
            )
        );

        $expectArray = array();
        $result = array();

        foreach ($crewArray['data'] as $each) {
            $data = $each;

            $expectObject = new Crew();

            $expectObject->setId($data['id']);

            $attributes = $data['attributes'];

            $expectObject = $this->setMethods($expectObject, $attributes);

            $result[$data['id']] = $expectObject;
        }

        $actual = $this->stub->arrayToObjects($crewArray);

        $expectArray = [2, $result];

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
        $crew = \Sdk\Crew\Utils\MockFactory::generateCrewObject(1, 1);

        $actual = $this->stub->objectToArray($crew);

        $expectArray = array(
            'data'=>array(
                'type'=>'crews',
                'id'=>$crew->getId()
            )
        );

        $expectArray['data']['attributes'] = array(
            'cellphone'=>$crew->getCellphone(),
            'realName'=>$crew->getRealName(),
            'userName'=>$crew->getUserName(),
            'password'=>$crew->getPassword(),
            'oldPassword'=>$crew->getOldPassword(),
            'avatar'=>$crew->getAvatar(),
            'gender'=>$crew->getGender(),
            'workNumber'=>$crew->getWorkNumber()
        );
        
        $this->assertEquals($expectArray, $actual);
    }
}
