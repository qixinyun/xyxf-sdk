<?php
namespace Sdk\DispatchDepartment\Utils;

use Sdk\DispatchDepartment\Model\DispatchDepartment;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateDispatchDepartmentArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateDispatchDepartmentArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $dispatchDepartment = array();

        $dispatchDepartment = array(
            'data'=>array(
                'type'=>'dispatchDepartments',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //name
        $name = self::generateName($faker, $value);
        $attributes['name'] = $name;
        //remark
        $remark = self::generateRemark($faker, $value);
        $attributes['remark'] = $remark;
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

        $dispatchDepartment['data']['attributes'] = $attributes;
        //crew
        $dispatchDepartment['data']['relationships']['crew']['data'] = array(
            'type' => 'crews',
            'id' => $faker->randomNumber(1)
        );

        return $dispatchDepartment;
    }
    /**
     * [generateDispatchDepartmentObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateDispatchDepartmentObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : DispatchDepartment {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $dispatchDepartment = new DispatchDepartment($id);

        //name
        $name = self::generateName($faker, $value);
        $dispatchDepartment->setName($name);
        //remark
        $remark = self::generateRemark($faker, $value);
        $dispatchDepartment->setRemark($remark);
        //crew
        $crew = self::generateCrew($faker, $value);
        $dispatchDepartment->setCrew($crew);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $dispatchDepartment->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $dispatchDepartment->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $dispatchDepartment->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $dispatchDepartment->setStatus($status);

        return $dispatchDepartment;
    }

    private static function generateName($faker, array $value = array())
    {
        return $name = isset($value['name']) ?
        $value['name'] : $faker->word;
    }

    private static function generateRemark($faker, array $value = array())
    {
        return $remark = isset($value['remark']) ?
        $value['remark'] : $faker->word;
    }

    private static function generateCrew($faker, array $value = array())
    {
        return $crew = isset($value['crew']) ?
            $value['crew'] : \Sdk\Crew\Utils\MockFactory::generateCrewObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }
}
