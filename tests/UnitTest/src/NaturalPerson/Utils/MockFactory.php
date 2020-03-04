<?php
namespace Sdk\NaturalPerson\Utils;

use Sdk\NaturalPerson\Model\NaturalPerson;

use Sdk\Common\Model\IEnableAble;
use Sdk\NaturalPerson\Model\IdentityInfo;

class MockFactory
{
    /**
     * [generateNaturalPersonArray 生成实名认证数组]
     * @return [array] [认证信息]
     */
    public static function generateNaturalPersonArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $identifyPersonal = array();

        $identifyPersonal = array(
            'data'=>array(
                'type'=>'naturalPersons',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();
        //realName
        $realName = self::generateRealName($faker, $value);
        $attributes['realName'] = $realName;
        //member
        $member = self::generateMember($faker, $value);
        $attributes['member'] = $member;
        //cardId
        $cardId = self::generateCardId($faker, $value);
        $attributes['cardId'] = $cardId;
        //positivePhoto
        $positivePhoto = self::generatePositivePhoto($faker, $value);
        //reversePhoto
        $reversePhoto = self::generateReversePhoto($faker, $value);
        $attributes['reversePhoto'] = $reversePhoto;
        //handheldPhoto
        $handheldPhoto = self::generateHandheldPhoto($faker, $value);
        $attributes['handheldPhoto'] = $handheldPhoto;
        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $attributes['applyStatus'] = $applyStatus;
        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $attributes['rejectReason'] = $rejectReason;
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

        $identifyPersonal['data']['attributes'] = $attributes;

        $identifyPersonal['data']['relationships']['member']['data'] = array(
            'type' => 'members',
            'id' => $faker->randomNumber(1)
        );

        return $identifyPersonal;
    }
    /**
     * [generateNaturalPersonObject 生成实名认证信息对象]
     * @param  int|integer $id
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]             [认证信息]
     */
    public static function generateNaturalPersonObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : NaturalPerson {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $naturalPerson = new NaturalPerson($id);

        //realName
        $realName = self::generateRealName($faker, $value);
        $naturalPerson->setRealName($realName);
        //cardId
        $cardId = self::generateCardId($faker, $value);
        //positivePhoto
        $positivePhoto = self::generatePositivePhoto($faker, $value);
        //reversePhoto
        $reversePhoto = self::generateReversePhoto($faker, $value);
        //handheldPhoto
        $handHeldPhoto = self::generateHandHeldPhoto($faker, $value);
        $naturalPerson->setIdentityInfo(
            new IdentityInfo(
                $cardId,
                $positivePhoto,
                $reversePhoto,
                $handHeldPhoto
            )
        );
        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $naturalPerson->setApplyStatus($applyStatus);
        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $naturalPerson->setRejectReason($rejectReason);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $naturalPerson->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $naturalPerson->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $naturalPerson->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $naturalPerson->setStatus($status);
        //member
        $member = self::generateMember($faker, $value);
        $naturalPerson->setMember($member);

        return $naturalPerson;
    }

    private static function generateRealName($faker, array $value = array())
    {
        return $realName = isset($value['realName']) ? $value['realName'] : $faker->name;
    }

    private static function generateMember($faker, array $value = array())
    {
        return $member = isset($value['member']) ?
            $value['member'] : \Sdk\Member\Utils\MockFactory::generateMemberObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }

    private static function generateCardId($faker, array $value = array())
    {
        return $cardId = isset($value['cardId']) ?
            $value['cardId'] : $faker->creditCardNumber;
    }

    private static function generatePositivePhoto($faker, array $value = array())
    {
        return $positivePhoto = isset($attributes['positivePhoto']) ?
        $attributes['positivePhoto'] : array('name'=>'positivePhoto','identify'=>'positivePhoto.jpg');
    }

    private static function generateReversePhoto($faker, array $value = array())
    {
        return $reversePhoto = isset($attributes['reversePhoto']) ?
        $attributes['reversePhoto'] : array('name'=>'reversePhoto','identify'=>'reversePhoto.jpg');
    }

    private static function generateHandHeldPhoto($faker, array $value = array())
    {
        return $handHeldPhoto = isset($attributes['handheldPhoto']) ?
        $attributes['handheldPhoto'] : array('name'=>'handheldPhoto','identify'=>'handheldPhoto.jpg');
    }

    private static function generateApplyStatus($faker, array $value = array())
    {
        return $applyStatus = isset($value['applyStatus']) ?
                $value['applyStatus'] : $faker->randomElement(
                    $array = array(
                        NaturalPerson::APPLY_STATUS['PENDING'],
                        NaturalPerson::APPLY_STATUS['APPROVE'],
                        NaturalPerson::APPLY_STATUS['REJECT']
                    )
                );
    }

    private static function generateRejectReason($faker, array $value = array())
    {
        return $rejectReason = isset($value['rejectReason']) ?
        $value['rejectReason'] : $faker->paragraph;
    }
}
