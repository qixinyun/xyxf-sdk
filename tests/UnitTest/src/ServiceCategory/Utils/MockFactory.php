<?php
namespace Sdk\ServiceCategory\Utils;

use Sdk\ServiceCategory\Model\ParentCategory;
use Sdk\ServiceCategory\Model\ServiceCategory;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateParentCategoryArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateParentCategoryArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $parentCategory = array();

        $parentCategory = array(
            'data'=>array(
                'type'=>'parentCategories',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //name
        $name = self::generateName($faker, $value);
        $attributes['name'] = $name;
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

        $parentCategory['data']['attributes'] = $attributes;

        return $parentCategory;
    }
    /**
     * [generateParentCategoryObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateParentCategoryObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : ParentCategory {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $parentCategory = new ParentCategory($id);

        //name
        $name = self::generateName($faker, $value);
        $parentCategory->setName($name);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $parentCategory->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $parentCategory->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $parentCategory->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $parentCategory->setStatus($status);

        return $parentCategory;
    }

    /**
     * [generateServiceCategoryArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateServiceCategoryArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $serviceCategory = array();

        $serviceCategory = array(
            'data'=>array(
                'type'=>'parentCategories',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //name
        $name = self::generateName($faker, $value);
        $attributes['name'] = $name;
        //isQualification
        $isQualification = self::generateIsQualification($faker, $value);
        $attributes['isQualification'] = $isQualification;
        //qualificationName
        $qualificationName = self::generateQualificationName($faker, $value);
        $attributes['qualificationName'] = $qualificationName;
        //commission
        $commission = self::generateCommission($faker, $value);
        $attributes['commission'] = $commission;
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

        $serviceCategory['data']['attributes'] = $attributes;
        //parentCategory
        $serviceCategory['data']['relationships']['parentCategory']['data'] = array(
            'type' => 'serviceCategories',
            'id' => $faker->randomNumber(1)
        );

        return $serviceCategory;
    }

    /**
     * [generateServiceCategoryObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateServiceCategoryObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : ServiceCategory {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $serviceCategory = new ServiceCategory($id);

        //name
        $name = self::generateName($faker, $value);
        $serviceCategory->setName($name);
        //parentCategory
        $parentCategory = self::generateParentCategory($faker, $value);
        $serviceCategory->setParentCategory($parentCategory);
        //isQualification
        $isQualification = self::generateIsQualification($faker, $value);
        $serviceCategory->setIsQualification($isQualification);
        //qualificationName
        $qualificationName = self::generateQualificationName($faker, $value);
        $serviceCategory->setQualificationName($qualificationName);
        //commission
        $commission = self::generateCommission($faker, $value);
        $serviceCategory->setCommission($commission);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $serviceCategory->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $serviceCategory->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $serviceCategory->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $serviceCategory->setStatus($status);

        return $serviceCategory;
    }


    private static function generateName($faker, array $value = array())
    {
        return $name = isset($value['name']) ?
        $value['name'] : $faker->name;
    }

    private static function generateIsQualification($faker, array $value = array())
    {
        return $isQualification = isset($value['isQualification']) ?
        $value['isQualification'] : $faker->randomElement(
            $array = array(
                \Sdk\ServiceCategory\Model\ServiceCategory::IS_QUALIFICATION['YES'],
                \Sdk\ServiceCategory\Model\ServiceCategory::IS_QUALIFICATION['NO']
            )
        );
    }

    private static function generateQualificationName($faker, array $value = array())
    {
        return $qualificationName = isset($value['qualificationName']) ?
        $value['qualificationName'] : $faker->name;
    }

    private static function generateCommission($faker, array $value = array())
    {
        return $commission = isset($value['commission']) ?
        $value['commission'] : 2;
    }

    private static function generateParentCategory($faker, array $value = array())
    {
        return $parentCategory = isset($value['parentCategory']) ?
            $value['parentCategory'] : self::generateParentCategoryObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }
}
