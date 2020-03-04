<?php
namespace Sdk\MemberAccount\Utils;

use Sdk\MemberAccount\Model\MemberAccount;
use Sdk\Member\Model\Member;

class MockFactory
{
    /**
     * [generateMemberAccountArray 生成账户信息数组]
     * @return [array] [账户数组]
     */
    public static function generateMemberAccountArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $memberAccount = array();

        $memberAccount = array(
            'data'=>array(
                'type'=>'memberAccount',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //accountBalance
        $accountBalance = self::generateAccountBalance($faker, $value);
        $attributes['accountBalance'] = $accountBalance;
        //frozenAccountBalance
        $frozenAccountBalance = self::generateFrozenAccountBalance($faker, $value);
        $attributes['frozenAccountBalance'] = $frozenAccountBalance;
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

        $memberAccount['data']['attributes'] = $attributes;

        //member
        $memberAccount['data']['relationships']['member']['data'] = array(
            'type' => 'members',
            'id' => $faker->randomNumber(1)
        );

        return $memberAccount;
    }

    /**
     * [generateMemberAccountObject 生成账户对象对象]
     * @param  int|integer $id    [账户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [账户对象]
     */
    public static function generateMemberAccountObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : MemberAccount {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $memberAccount = new MemberAccount($id);

        //accountBalance
        $accountBalance = self::generateAccountBalance($faker, $value);
        $memberAccount->setAccountBalance($accountBalance);
        //frozenAccountBalance
        $frozenAccountBalance = self::generateFrozenAccountBalance($faker, $value);
        $memberAccount->setFrozenAccountBalance($frozenAccountBalance);
        //member
        $member = self::generateMember($faker, $value);
        $memberAccount->setMember($member);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $memberAccount->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $memberAccount->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $memberAccount->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $memberAccount->setStatus($status);

        return $memberAccount;
    }

    private static function generateAccountBalance($faker, array $value = array())
    {
        return $accountBalance = isset($value['accountBalance']) ?
        $value['accountBalance'] : $faker->randomFloat;
    }

    private static function generateFrozenAccountBalance($faker, array $value = array())
    {
        return $frozenAccountBalance = isset($value['frozenAccountBalance']) ?
        $value['frozenAccountBalance'] : $faker->randomFloat;
    }

    private static function generateMember($faker, array $value = array())
    {
        return $member = isset($value['member']) ?
            $value['member'] : \Sdk\Member\Utils\MockFactory::generateMemberObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }
}
