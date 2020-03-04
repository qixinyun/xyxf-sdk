<?php
namespace Sdk\Common\Utils;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    public static function generateCreateTime($faker, array $value = array())
    {
        return $createTime = isset($value['createTime']) ?
        $value['createTime'] : $faker->unixTime();
    }

    public static function generateUpdateTime($faker, array $value = array())
    {
        return $updateTime = isset($value['updateTime']) ?
        $value['updateTime'] : $faker->unixTime();
    }

    public static function generateStatusTime($faker, array $value = array())
    {
        return $statusTime = isset($value['statusTime']) ?
        $value['statusTime'] : $faker->unixTime();
    }

    public static function generateStatus($faker, array $value = array())
    {
        return $status = isset($value['status']) ?
        $value['status'] : $faker->randomElement(
            $array = array(
                IEnableAble::STATUS['ENABLED'],
                IEnableAble::STATUS['DISABLED']
            )
        );
    }
}
