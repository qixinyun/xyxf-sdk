<?php
namespace Sdk\Member\Utils;

use Sdk\Member\Model\Member;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateMemberArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateMemberArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $member = array();

        $member = array(
            'data'=>array(
                'type'=>'members',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //nickName
        $nickName = self::generateNickName($faker, $value);
        $attributes['nickName'] = $nickName;

        //birthday
        $birthday = self::generateBirthday($faker, $value);
        $attributes['birthday'] = $birthday;

        //area
        $area = self::generateArea($faker, $value);
        $attributes['area'] = $area;

        //address
        $address = self::generateAddress($faker, $value);
        $attributes['address'] = $address;

        //briefIntroduction
        $briefIntroduction = self::generateBriefIntroduction($faker, $value);
        $attributes['briefIntroduction'] = $briefIntroduction;

        $user = \Sdk\User\Utils\MockFactory::generateUserArray();

        $member['data']['attributes'] = array_merge($user['data']['attributes'], $attributes);
        
        return $member;
    }
    /**
     * [generateMemberObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateMemberObject(int $id = 0, int $seed = 0, array $value = array()) : Member
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $member = new Member($id);

        $member = \Sdk\User\Utils\MockFactory::generateUserObject($member);

        //nickName
        $nickName = self::generateNickName($faker, $value);
        $member->setNickname($nickName);

        //birthday
        $birthday = self::generateBirthday($faker, $value);
        $member->setBirthday($birthday);

        //area
        $area = self::generateArea($faker, $value);
        $member->setArea($area);

        //address
        $address = self::generateAddress($faker, $value);
        $member->setAddress($address);

        //briefIntroduction
        $briefIntroduction = self::generateBriefIntroduction($faker, $value);
        $member->setBriefIntroduction($briefIntroduction);

        return $member;
    }

    private static function generateNickName($faker, array $value = array())
    {
        return $nickName = isset($value['nickName']) ?
        $value['nickName'] : $faker->name;
    }

    private static function generateBirthday($faker, array $value = array())
    {
        return $birthday = isset($value['birthday']) ?
        $value['birthday'] : '2019-10-30';
    }

    private static function generateArea($faker, array $value = array())
    {
        return $area = isset($value['area']) ?
        $value['area'] : '陕西省,西安市,雁塔区';
    }

    private static function generateAddress($faker, array $value = array())
    {
        return $address = isset($value['address']) ?
        $value['address'] : $faker->name;
    }

    private static function generateBriefIntroduction($faker, array $value = array())
    {
        return $briefIntroduction = isset($value['briefIntroduction']) ?
        $value['briefIntroduction'] : $faker->name;
    }
}
