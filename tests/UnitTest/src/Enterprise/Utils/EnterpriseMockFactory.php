<?php
namespace Sdk\Enterprise\Utils;

use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Model\ContactsInfo;
use Sdk\Enterprise\Model\LegalPersonInfo;

class EnterpriseMockFactory
{
    /**
     * [generateEnterpriseArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateEnterpriseArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $enterprise = array();

        $enterprise = array(
            'data'=>array(
                'type'=>'enterprises',
                'id'=>$faker->randomNumber(2)
            )
        );

        $value = array();
        $attributes = array();

        //name
        $name = self::generateName($faker, $value);
        $attributes['name'] = $name;
        //unifiedSocialCreditCode
        $unifiedSocialCreditCode = self::generateUnifiedSocialCreditCode($faker, $value);
        $attributes['unifiedSocialCreditCode'] = $unifiedSocialCreditCode;
        //logo
        $logo = self::generateLogo($faker, $value);
        $attributes['logo'] = $logo;
        //businessLicense
        $businessLicense = self::generateBusinessLicense($faker, $value);
        $attributes['businessLicense'] = $businessLicense;
        //powerAttorney
        $powerAttorney = self::generatePowerAttorney($faker, $value);
        $attributes['powerAttorney'] = $powerAttorney;
        //contactsName
        $contactsName = self::generateContactsName($faker, $value);
        $attributes['contactsName'] = $contactsName;
        //contactsCellphone
        $contactsCellphone = self::generateContactsCellphone($faker, $value);
        $attributes['contactsCellphone'] = $contactsCellphone;
        //contactsArea
        $contactsArea = self::generateContactsArea($faker, $value);
        $attributes['contactsArea'] = $contactsArea;
        //contactsAddress
        $contactsAddress = self::generateContactsAddress($faker, $value);
        $attributes['contactsAddress'] = $contactsAddress;
        //legalPersonName
        $legalPersonName = self::generateLegalPersonName($faker, $value);
        $attributes['legalPersonName'] = $legalPersonName;
        //legalPersonCardId
        $legalPersonCardId = self::generateCardId($faker, $value);
        $attributes['legalPersonCardId'] = $legalPersonCardId;
        //legalPersonPositivePhoto
        $legalPersonPositivePhoto = self::generatePositivePhoto($faker, $value);
        $attributes['legalPersonPositivePhoto'] = $legalPersonPositivePhoto;
        //legalPersonReversePhoto
        $legalPersonReversePhoto = self::generateReversePhoto($faker, $value);
        $attributes['legalPersonReversePhoto'] = $legalPersonReversePhoto;
        //legalPersonHandheldPhoto
        $legalPersonHandheldPhoto = self::generateHandHeldPhoto($faker, $value);
        $attributes['legalPersonHandheldPhoto'] = $legalPersonHandheldPhoto;
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

        $enterprise['data']['attributes'] = $attributes;
        //member
        $enterprise['data']['relationships']['member']['data'] = array(
            'type' => 'members',
            'id' => $faker->randomNumber(1)
        );
        
        return $enterprise;
    }

    /**
     * [generateEnterpriseObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateEnterpriseObject(
        Enterprise $enterprise,
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : Enterprise {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        //name
        $name = self::generateName($faker, $value);
        $enterprise->setName($name);
        //unifiedSocialCreditCode
        $unifiedSocialCreditCode = self::generateUnifiedSocialCreditCode($faker, $value);
        $enterprise->setUnifiedSocialCreditCode($unifiedSocialCreditCode);
        //logo
        $logo = self::generateLogo($faker, $value);
        $enterprise->setLogo($logo);
        //businessLicense
        $businessLicense = self::generateBusinessLicense($faker, $value);
        $enterprise->setBusinessLicense($businessLicense);
        //powerAttorney
        $powerAttorney = self::generatePowerAttorney($faker, $value);
        $enterprise->setPowerAttorney($powerAttorney);

        //contactsName
        $contactsName = self::generateContactsName($faker, $value);
        //contactsCellphone
        $contactsCellphone = self::generateContactsCellphone($faker, $value);
        //contactsArea
        $contactsArea = self::generateContactsArea($faker, $value);
        //contactsAddress
        $contactsAddress = self::generateContactsAddress($faker, $value);
        $enterprise->setContactsInfo(
            new ContactsInfo(
                $contactsName,
                $contactsCellphone,
                $contactsArea,
                $contactsAddress
            )
        );

        //legalPersonName
        $legaPersonName = self::generateLegalPersonName($faker, $value);
        //legalPersonCardId
        $legalPersonCardId = self::generateCardId($faker, $value);
        //legalPersonPositivePhoto
        $legalPersonPositivePhoto = self::generatePositivePhoto($faker, $value);
        //legalPersonReversePhoto
        $legalPersonReversePhoto = self::generateReversePhoto($faker, $value);
        //legalPersonHandheldPhoto
        $legalPersonHandheldPhoto = self::generateHandHeldPhoto($faker, $value);
        $enterprise->setLegalPersonInfo(
            new LegalPersonInfo(
                $legaPersonName,
                $legalPersonCardId,
                $legalPersonPositivePhoto,
                $legalPersonReversePhoto,
                $legalPersonHandheldPhoto
            )
        );

        //member
        $member = self::generateMember($faker, $value);
        $enterprise->setMember($member);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $enterprise->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $enterprise->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $enterprise->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $enterprise->setStatus($status);

        return $enterprise;
    }

    private static function generateName($faker, array $value = array())
    {
        return $name = isset($value['name']) ?
        $value['name'] : $faker->name;
    }

    private static function generateUnifiedSocialCreditCode($faker, array $value = array())
    {
        return $unifiedSocialCreditCode = isset($value['unifiedSocialCreditCode']) ?
        $value['unifiedSocialCreditCode'] : $faker->bothify('######????????##');
    }

    private static function generateLogo($faker, array $value = array())
    {
        return $logo = isset($value['logo']) ?
        $value['logo'] : array('name' => 'logo', 'identify' => 'logo.png');
    }

    private static function generateBusinessLicense($faker, array $value = array())
    {
        return $businessLicense = isset($value['businessLicense']) ?
        $value['businessLicense'] : array('name' => 'businessLicense', 'identify' => 'businessLicense.png');
    }

    private static function generatePowerAttorney($faker, array $value = array())
    {
        return $powerAttorney = isset($value['powerAttorney']) ?
        $value['powerAttorney'] : array('name' => 'powerAttorney', 'identify' => 'powerAttorney.png');
    }

    private static function generateContactsName($faker, array $value = array())
    {
        return $contactsName = isset($value['contactsName']) ?
            $value['contactsName'] : $faker->name;
    }

    private static function generateContactsCellphone($faker, array $value = array())
    {
        return $contactsCellphone = isset($value['contactsCellphone']) ?
            $value['contactsCellphone'] : $faker->phoneNumber;
    }

    private static function generateContactsArea($faker, array $value = array())
    {
        return $contactsArea = isset($value['contactsArea']) ?
            $value['contactsArea'] : $faker->city;
    }

    private static function generateContactsAddress($faker, array $value = array())
    {
        return $contactsAddress = isset($value['contactsAddress']) ?
            $value['contactsAddress'] : $faker->address;
    }

    private static function generateLegalPersonName($faker, array $value = array())
    {
        return $legaPersonName = isset($value['legaPersonName']) ?
            $value['legaPersonName'] : $faker->name;
    }

    private static function generateCardId($faker, array $value = array())
    {
        return $cardId = isset($value['cardId']) ?
            $value['cardId'] : $faker->creditCardNumber;
    }

    private static function generatePositivePhoto($faker, array $value = array())
    {
        return $positivePhoto = isset($attributes['positivePhoto']) ?
        $attributes['positivePhoto'] : array('name'=>'positivePhoto','identify'=>'positivePhoto.png');
    }

    private static function generateReversePhoto($faker, array $value = array())
    {
        return $reversePhoto = isset($attributes['reversePhoto']) ?
        $attributes['reversePhoto'] : array('name'=>'reversePhoto','identify'=>'reversePhoto.png');
    }

    private static function generateHandHeldPhoto($faker, array $value = array())
    {
        return $handHeldPhoto = isset($attributes['handheldPhoto']) ?
        $attributes['handheldPhoto'] : array('name'=>'handheldPhoto','identify'=>'handheldPhoto.png');
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
