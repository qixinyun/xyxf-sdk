<?php
namespace Sdk\ServiceRequirement\Utils;

use Sdk\ServiceRequirement\Model\ServiceRequirement;

use Sdk\Common\Model\IApplyAble;

class MockFactory
{
    /**
     * [generateServiceRequirementArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateServiceRequirementArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $serviceRequirement = array();

        $serviceRequirement = array(
            'data'=>array(
                'type'=>'serviceRequirements',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //title
        $title = self::generateTitle($faker, $value);
        $attributes['title'] = $title;
        //detail
        $detail = self::generateDetail($faker, $value);
        $attributes['detail'] = $detail;
        //minPrice
        $minPrice = self::generateMinPrice($faker, $value);
        $attributes['minPrice'] = $minPrice;
        //maxPrice
        $maxPrice = self::generateMaxPrice($faker, $value);
        $attributes['maxPrice'] = $maxPrice;
        //validityStartTime
        $validityStartTime = self::generateValidityStartTime($faker, $value);
        $attributes['validityStartTime'] = $validityStartTime;
        //validityEndTime
        $validityEndTime = self::generateValidityEndTime($faker, $value);
        $attributes['validityEndTime'] = $validityEndTime;
        //contactName
        $contactName = self::generateContactName($faker, $value);
        $attributes['contactName'] = $contactName;
        //contactPhone
        $contactPhone = self::generateContactPhone($faker, $value);
        $attributes['contactPhone'] = $contactPhone;
        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $attributes['rejectReason'] = $rejectReason;
        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $attributes['applyStatus'] = $applyStatus;
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

        $serviceRequirement['data']['attributes'] = $attributes;
        //member
        $serviceRequirement['data']['relationships']['member']['data'] = array(
            'type' => 'members',
            'id' => $faker->randomNumber(1)
        );
        //serviceCategory
        $serviceRequirement['data']['relationships']['serviceCategory']['data'] = array(
            'type' => 'serviceCategories',
            'id' => $faker->randomNumber(1)
        );

        return $serviceRequirement;
    }
    /**
     * [generateServiceRequirementObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateServiceRequirementObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : ServiceRequirement {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $serviceRequirement = new ServiceRequirement($id);

        //title
        $title = self::generateTitle($faker, $value);
        $serviceRequirement->setTitle($title);
        //detail
        $detail = self::generateDetail($faker, $value);
        $serviceRequirement->setDetail($detail);
        //minPrice
        $minPrice = self::generateMinPrice($faker, $value);
        $serviceRequirement->setMinPrice($minPrice);
        //maxPrice
        $maxPrice = self::generateMaxPrice($faker, $value);
        $serviceRequirement->setMaxPrice($maxPrice);
        //validityStartTime
        $validityStartTime = self::generateValidityStartTime($faker, $value);
        $serviceRequirement->setValidityStartTime($validityStartTime);
        //validityEndTime
        $validityEndTime = self::generateValidityEndTime($faker, $value);
        $serviceRequirement->setValidityEndTime($validityEndTime);
        //contactName
        $contactName = self::generateContactName($faker, $value);
        $serviceRequirement->setContactName($contactName);
        //contactPhone
        $contactPhone = self::generateContactPhone($faker, $value);
        $serviceRequirement->setContactPhone($contactPhone);
        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $serviceRequirement->setRejectReason($rejectReason);
        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $serviceRequirement->setApplyStatus($applyStatus);
        //member
        $member = self::generateMember($faker, $value);
        $serviceRequirement->setMember($member);
        //serviceCategory
        $serviceCategory = self::generateServiceCategory($faker, $value);
        $serviceRequirement->setServiceCategory($serviceCategory);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $serviceRequirement->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $serviceRequirement->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $serviceRequirement->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $serviceRequirement->setStatus($status);

        return $serviceRequirement;
    }

    private static function generateTitle($faker, array $value = array())
    {
        return $title = isset($value['title']) ?
        $value['title'] : $faker->word;
    }

    private static function generateDetail($faker, array $value = array())
    {
        return $detail = isset($value['detail']) ?
        $value['detail'] : array(array("type"=>"text", "value"=>"文本内容"));
    }

    private static function generateMinPrice($faker, array $value = array())
    {
        return $minPrice = isset($value['minPrice']) ?
        $value['minPrice'] : $faker->numerify;
    }

    private static function generateMaxPrice($faker, array $value = array())
    {
        return $maxPrice = isset($value['maxPrice']) ?
        $value['maxPrice'] : $faker->numerify;
    }

    private static function generateValidityStartTime($faker, array $value = array())
    {
        return $validityStartTime = isset($value['validityStartTime']) ?
        $value['validityStartTime'] : time();
    }

    private static function generateValidityEndTime($faker, array $value = array())
    {
        return $validityEndTime = isset($value['validityEndTime']) ?
        $value['validityEndTime'] : time();
    }

    private static function generateContactName($faker, array $value = array())
    {
        return $contactName = isset($value['contactName']) ?
        $value['contactName'] : $faker->name;
    }

    private static function generateContactPhone($faker, array $value = array())
    {
        return $contactPhone = isset($value['contactPhone']) ?
        $value['contactPhone'] : $faker->phoneNumber;
    }

    private static function generateRejectReason($faker, array $value = array())
    {
        return $rejectReason = isset($value['rejectReason']) ?
        $value['rejectReason'] : $faker->word;
    }

    public static function generateApplyStatus($faker, array $value = array())
    {
        return $applyStatus = isset($value['applyStatus']) ?
        $value['applyStatus'] : $faker->randomElement(
            $array = array(
                IApplyAble::APPLY_STATUS['PENDING'],
                IApplyAble::APPLY_STATUS['APPROVE'],
                IApplyAble::APPLY_STATUS['REJECT']
            )
        );
    }

    private static function generateMember($faker, array $value = array())
    {
        return $member = isset($value['member']) ?
            $value['member'] : \Sdk\Member\Utils\MockFactory::generateMemberObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }

    private static function generateServiceCategory($faker, array $value = array())
    {
        return $serviceCategory = isset($value['serviceCategory']) ?
            $value['serviceCategory'] : \Sdk\ServiceCategory\Utils\MockFactory::generateServiceCategoryObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }
}
