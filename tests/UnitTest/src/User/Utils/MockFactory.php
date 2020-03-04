<?php
namespace Sdk\User\Utils;

use Sdk\User\Model\User;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateUserArray 生成通用用户数组]
     * @return [array] [通用用户数组]
     */
    public static function generateUserArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $user = array();

        $value = array();
        $attributes = array();
        //cellphone
        $cellphone = self::generateCellphone($faker, $value);
        $attributes['cellphone'] = $cellphone;
        //realName
        $realName = self::generateRealName($faker, $value);
        $attributes['realName'] = $realName;
        //userName
        $userName = self::generateUserName($faker, $value);
        $attributes['userName'] = $userName;
        //password
        $password = self::generatePassword($faker, $value);
        $attributes['password'] = $password;
        //oldPassword
        $oldPassword = self::generateOldPassword($faker, $value);
        $attributes['oldPassword'] = $oldPassword;
        //avatar
        $avatar = self::generateAvatar($faker, $value);
        $attributes['avatar'] = $avatar;
        //gender
        $gender = self::generateGender($faker, $value);
        $attributes['gender'] = $gender;
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $attributes['createTime'] = $createTime;
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $attributes['updateTime'] = $updateTime;
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $attributes['statusTime'] = $statusTime;
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $attributes['status'] = $status;

        $user['data']['attributes'] = $attributes;
        
        return $user;
    }
    /**
     * [generateUserObject 生成通用用户数组]
     * @param  User        $user
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]             [通用用户对象]
     */
    public static function generateUserObject(User $user, int $seed = 0, array $value = array()) : User
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        //cellphone
        $cellphone = self::generateCellphone($faker, $value);
        $user->setCellphone($cellphone);
        //realName
        $realName = self::generateRealName($faker, $value);
        $user->setRealName($realName);
        //userName
        $userName = self::generateUserName($faker, $value);
        $user->setUserName($userName);
        //password
        $password = self::generatePassword($faker, $value);
        $user->setPassword($password);
        //oldPassword
        $oldPassword = self::generateOldPassword($faker, $value);
        $user->setOldPassword($oldPassword);
        //avatar
        $avatar = self::generateAvatar($faker, $value);
        $user->setAvatar($avatar);
        //gender
        $gender = self::generateGender($faker, $value);
        $user->setGender($gender);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $user->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $user->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $user->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $user->setStatus($status);

        return $user;
    }

    private static function generateCellphone($faker, array $value = array())
    {
        return $cellphone = isset($value['cellphone']) ?
        $value['cellphone'] : $faker->phoneNumber;
    }

    private static function generateRealName($faker, array $value = array())
    {
        return $realName = isset($value['realName']) ?
        $value['realName'] : $faker->name;
    }

    private static function generateUserName($faker, array $value = array())
    {
        return $userName = isset($value['userName']) ?
        $value['userName'] : $faker->name;
    }

    private static function generatePassword($faker, array $value = array())
    {
        return $password = isset($value['password']) ?
        $value['password'] : $faker->password;
    }

    private static function generateOldPassword($faker, array $value = array())
    {
        return $password = isset($value['password']) ?
        $value['password'] : $faker->password;
    }

    private static function generateAvatar($faker, array $value = array())
    {
        return $avatar = isset($value['avatar']) ?
        $value['avatar'] :
        array(
            'name'=>$faker->word,
            'identify'=>$faker->word.'jpg'
        );
    }

    private static function generateGender($faker, array $value = array())
    {
        return $gender = isset($value['gender']) ? $value['gender'] : $faker->randomElement(
            $array = array(
                User::GENDER['GENDER_NULL'],
                User::GENDER['GENDER_MALE'],
                User::GENDER['GENDER_FEMALE']
            )
        );
    }
}
