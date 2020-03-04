<?php
namespace Sdk\Authentication\Utils;

use Sdk\Authentication\Model\Authentication;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateAuthenticationArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateAuthenticationArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $authentication = array();

        $authentication = array(
            'data'=>array(
                'type'=>'authentications',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //enterpriseName
        $enterpriseName = self::generateEnterpriseName($faker, $value);
        $attributes['enterpriseName'] = $enterpriseName;
        //qualificationImage
        $qualificationImage = self::generateQualificationImage($faker, $value);
        $attributes['qualificationImage'] = $qualificationImage;
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

        $authentication['data']['attributes'] = $attributes;
        //serviceCategory
        $authentication['data']['relationships']['serviceCategory']['data'] = array(
            'type' => 'serviceCategories',
            'id' => $faker->randomNumber(1)
        );
        //enterprise
        $authentication['data']['relationships']['enterprise']['data'] = array(
            'type' => 'enterprises',
            'id' => $faker->randomNumber(1)
        );

        return $authentication;
    }
    /**
     * [generateAuthenticationObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateAuthenticationObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : Authentication {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $authentication = new Authentication($id);

        //enterpriseName
        $enterpriseName = self::generateEnterpriseName($faker, $value);
        $authentication->setEnterpriseName($enterpriseName);
        //qualificationImage
        $qualificationImage = self::generateQualificationImage($faker, $value);
        $authentication->setQualificationImage($qualificationImage);
        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $authentication->setRejectReason($rejectReason);
        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $authentication->setApplyStatus($applyStatus);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $authentication->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $authentication->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $authentication->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $authentication->setStatus($status);
        //enterprise
        $enterprise = self::generateEnterprise($faker, $value);
        $authentication->setEnterprise($enterprise);
        //serviceCategory
        $serviceCategory = self::generateServiceCategory($faker, $value);
        $authentication->setServiceCategory($serviceCategory);

        return $authentication;
    }

    private static function generateEnterpriseName($faker, array $value = array())
    {
        return $enterpriseName = isset($value['enterpriseName']) ?
        $value['enterpriseName'] : $faker->name;
    }

    private static function generateQualificationImage($faker, array $value = array())
    {
        return $qualificationImage = isset($value['qualificationImage']) ?
        $value['qualificationImage'] : array('name' => 'qualificationImage', 'identify' => 'qualificationImage.jpg');
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
                        Authentication::APPLY_STATUS['PENDING'],
                        Authentication::APPLY_STATUS['APPROVE'],
                        Authentication::APPLY_STATUS['REJECT']
                    )
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

    private static function generateEnterprise($faker, array $value = array())
    {
        return $enterprise = isset($value['enterprise']) ?
            $value['enterprise'] : \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseObject(
                new \Sdk\Enterprise\Model\Enterprise(),
                $faker->numerify(),
                $faker->numerify()
            );
    }
}
