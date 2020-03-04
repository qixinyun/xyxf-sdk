<?php
namespace Sdk\User\Translator;

use Sdk\User\Model\User;

use PHPUnit\Framework\TestCase;

class UserRestfulTranslatorTest extends TestCase
{
    private $translator;

    public function setUp()
    {
        $this->translator = $this->getMockForAbstractClass(UserRestfulTranslator::class);
    }
    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertEquals(array(), $result);
    }

    public function setMethods($expectObject, $attributes)
    {
        if (isset($attributes['cellphone'])) {
            $expectObject->setCellphone($attributes['cellphone']);
        }
        if (isset($attributes['realName'])) {
            $expectObject->setRealName($attributes['realName']);
        }
        if (isset($attributes['userName'])) {
            $expectObject->setUserName($attributes['userName']);
        }
        if (isset($attributes['password'])) {
            $expectObject->setPassword($attributes['password']);
        }
        if (isset($attributes['oldPassword'])) {
            $expectObject->setOldPassword($attributes['oldPassword']);
        }
        if (isset($attributes['avatar'])) {
            $expectObject->setAvatar($attributes['avatar']);
        }
        if (isset($attributes['gender'])) {
            $expectObject->setGender($attributes['gender']);
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
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }

        return $expectObject;
    }
    /**
     * 传参正确对象, 返回对应数组
     */
    /*public function testObjectToArrayCorrectObject()
    {
        $user = \Sdk\User\Utils\MockFactory::generateUserObject(2, 2);
        
        $actual = $this->translator->objectToArray($user);

        $expectArray = array(
            'data'=>array(
                'id'=>$user->getId()
            )
        );

        $expectArray['data']['attributes'] = array(
            'cellphone'=>$user->getCellphone(),
            'realName'=>$user->getRealName(),
            'userName'=>$user->getUserName(),
            'oldPassword'=>$user->getOldPassword(),
            'password'=>$user->getPassword(),
            'avatar'=>$user->getAvatar(),
            'gender'=>$user->getGender()
        );

        $this->assertEquals($expectArray, $actual);
    }*/
}
