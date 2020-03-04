<?php
namespace Sdk\Service\Utils;

use Sdk\Service\Model\Service;
use Sdk\Enterprise\Model\Enterprise;

use Sdk\Common\Model\IApplyAble;

class MockFactory
{
    /**
     * [generateServiceArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateServiceArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $service = array();

        $service = array(
            'data'=>array(
                'type'=>'service',
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
        //cover
        $cover = self::generateCover($faker, $value);
        $attributes['cover'] = $cover;
        //price
        $price = self::generatePrice($faker, $value);
        $attributes['price'] = $price;
        //minPrice
        $minPrice = self::generateMinPrice($faker, $value);
        $attributes['minPrice'] = $minPrice;
        //maxPrice
        $maxPrice = self::generateMaxPrice($faker, $value);
        $attributes['maxPrice'] = $maxPrice;
        //contract
        $contract = self::generateContract($faker, $value);
        $attributes['contract'] = $contract;
        //volume
        $volume = self::generateVolume($faker, $value);
        $attributes['volume'] = $volume;
        //attentionDegree
        $attentionDegree = self::generateAttentionDegree($faker, $value);
        $attributes['attentionDegree'] = $attentionDegree;
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

        $service['data']['attributes'] = $attributes;
        //enterprise
        $service['data']['relationships']['enterprise']['data'] = array(
            'type' => 'enterprises',
            'id' => $faker->randomNumber(1)
        );
        //serviceCategory
        $service['data']['relationships']['serviceCategory']['data'] = array(
            'type' => 'serviceCategories',
            'id' => $faker->randomNumber(1)
        );

        return $service;
    }
    /**
     * [generateServiceObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateServiceObject(int $id = 0, int $seed = 0, array $value = array()) : Service
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $service = new Service($id);

        //title
        $title = self::generateTitle($faker, $value);
        $service->setTitle($title);
        //detail
        $detail = self::generateDetail($faker, $value);
        $service->setDetail($detail);
        //cover
        $cover = self::generateCover($faker, $value);
        $service->setCover($cover);
        //price
        $price = self::generatePrice($faker, $value);
        $service->setPrice($price);
        //minPrice
        $minPrice = self::generateMinPrice($faker, $value);
        $service->setMinPrice($minPrice);
        //maxPrice
        $maxPrice = self::generateMaxPrice($faker, $value);
        $service->setMaxPrice($maxPrice);
        //contract
        $contract = self::generateContract($faker, $value);
        $service->setContract($contract);
        //volume
        $volume = self::generateVolume($faker, $value);
        $service->setVolume($volume);
        //attentionDegree
        $attentionDegree = self::generateAttentionDegree($faker, $value);
        $service->setAttentionDegree($attentionDegree);
        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $service->setRejectReason($rejectReason);
        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $service->setApplyStatus($applyStatus);
        //enterprise
        $enterprise = self::generateEnterprise($faker, $value);
        $service->setEnterprise($enterprise);
        //serviceCategory
        $serviceCategory = self::generateServiceCategory($faker, $value);
        $service->setServiceCategory($serviceCategory);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $service->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $service->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $service->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $service->setStatus($status);

        return $service;
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

    private static function generateCover($faker, array $value = array())
    {
        return $cover = isset($value['cover']) ?
        $value['cover'] : array("name"=>"维修洗衣机服务", "identify"=>"3.jpg");
    }

    private static function generatePrice($faker, array $value = array())
    {
        return $price = isset($value['price']) ?
        $value['price'] : array(
                array("name"=>"天", "value"=>"1"),
                array("name"=>"月", "value"=>"30"),
                array("name"=>"年", "value"=>"300"),
            );
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

    private static function generateContract($faker, array $value = array())
    {
        return $contract = isset($value['contract']) ?
        $value['contract'] : array("name"=>"维修洗衣机服务合同", "identify"=>"3.pdf");
    }

    private static function generateVolume($faker, array $value = array())
    {
        return $volume = isset($value['volume']) ?
        $value['volume'] : $faker->numerify;
    }

    private static function generateAttentionDegree($faker, array $value = array())
    {
        return $attentionDegree = isset($value['attentionDegree']) ?
        $value['attentionDegree'] : $faker->numerify;
    }

    private static function generateRejectReason($faker, array $value = array())
    {
        return $rejectReason = isset($value['rejectReason']) ?
        $value['rejectReason'] : $faker->word;
    }

    private static function generateApplyStatus($faker, array $value = array())
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

    private static function generateEnterprise($faker, array $value = array())
    {
        return $enterprise = isset($value['enterprise']) ?
            $value['enterprise'] : \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseObject(
                new Enterprise(),
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
