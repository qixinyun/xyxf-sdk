<?php
namespace Sdk\Member\Translator;

use Sdk\Member\Model\Member;

use PHPUnit\Framework\TestCase;

use Sdk\User\Translator\UserRestfulTranslatorTest;

class MemberRestfulTranslatorTest extends TestCase
{
    private $translator;

    public function setUp()
    {
        $this->translator = new MemberRestfulTranslator();

        parent::setUp();
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->translator->arrayToObject(array(), new Member());
        $this->assertInstanceOf('Sdk\Member\Model\NullMember', $result);
    }

    private function setMethods(Member $expectObject, array $attributes)
    {
        $user = new UserRestfulTranslatorTest();
        $expectObject = $user->setMethods($expectObject, $attributes);
        
        if (isset($attributes['nickName'])) {
            $expectObject->setNickname($attributes['nickName']);
        }
        if (isset($attributes['birthday'])) {
            $expectObject->setBirthday($attributes['birthday']);
        }
        if (isset($attributes['area'])) {
            $expectObject->setArea($attributes['area']);
        }
        if (isset($attributes['address'])) {
            $expectObject->setAddress($attributes['address']);
        }
        if (isset($attributes['briefIntroduction'])) {
            $expectObject->setBriefIntroduction($attributes['briefIntroduction']);
        }

        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $member = \Sdk\Member\Utils\MockFactory::generateMemberArray();
        
        $data =  $member['data'];

        $actual = $this->translator->arrayToObject($member);

        $expectObject = new Member();

        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];
        
        $expectObject = $this->setMethods($expectObject, $attributes);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->translator->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $member = \Sdk\Member\Utils\MockFactory::generateMemberArray();
        $data =  $member['data'];

        $actual = $this->translator->arrayToObjects($member);

        $expectArray = array();

        $expectObject = new Member();

        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];

        $expectObject = $this->setMethods($expectObject, $attributes);

        $expectArray = [1, [$data['id']=>$expectObject]];

        $this->assertEquals($expectArray, $actual);
    }

    public function testArrayToObjectsCorrectObject()
    {
        $member[] = \Sdk\Member\Utils\MockFactory::generateMemberArray(1);
        $member[] = \Sdk\Member\Utils\MockFactory::generateMemberArray(2);

        $memberArray= array('data'=>array(
            $member[0]['data'],
            $member[1]['data']
        ));

        $expectArray = array();
        $results = array();

        foreach ($memberArray['data'] as $each) {
            $data =  $each;

            $expectObject = new Member();

            $expectObject->setId($data['id']);

            $attributes = $data['attributes'];

            $expectObject = $this->setMethods($expectObject, $attributes);

            $results[$data['id']] = $expectObject;
        }

        $actual = $this->translator->arrayToObjects($memberArray);

        $expectArray = [2, $results];

        $this->assertEquals($expectArray, $actual);
    }

    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertEquals(array(), $result);
    }

    /**
     * 传参正确对象, 返回对应数组
     */
    public function testObjectToArrayCorrectObject()
    {
        $member = \Sdk\Member\Utils\MockFactory::generateMemberObject(1, 1);

        $actual = $this->translator->objectToArray($member);

        $expectArray = array(
            'data'=>array(
                'type'=>'members',
                'id'=>$member->getId()
            )
        );

        $expectArray['data']['attributes'] = array(
            'cellphone'=>$member->getCellphone(),
            'realName'=>$member->getRealName(),
            'userName'=>$member->getUserName(),
            'password'=>$member->getPassword(),
            'oldPassword'=>$member->getOldPassword(),
            'avatar'=>$member->getAvatar(),
            'gender'=>$member->getGender(),
            'nickName'=>$member->getNickname(),
            'birthday'=>$member->getBirthday(),
            'area'=>$member->getArea(),
            'address'=>$member->getAddress(),
            'briefIntroduction'=>$member->getBriefIntroduction()
        );

        $this->assertEquals($expectArray, $actual);
    }
}
