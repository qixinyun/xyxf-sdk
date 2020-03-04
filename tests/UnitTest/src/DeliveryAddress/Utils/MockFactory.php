<?php
namespace Sdk\DeliveryAddress\Utils;

use Sdk\DeliveryAddress\Model\DeliveryAddress;

use Sdk\Common\Model\IEnableAble;
use Sdk\DeliveryAddress\Model\IdentityInfo;

class MockFactory
{
    /**
     * [generateDeliveryAddressArray 生成收货地址数组]
     * @return [array] [地址信息]
     */
    public static function generateDeliveryAddressArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $deliveryAddress = array();

        $deliveryAddress = array(
            'data'=>array(
                'type'=>'deliveryAddress',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();
        //area
        $area = self::generateArea($faker, $value);
        $attributes['area'] = $area;
        //address
        $address = self::generateAddress($faker, $value);
        $attributes['address'] = $address;
        //postalCode
        $postalCode = self::generatePostalCode($faker, $value);
        $attributes['postalCode'] = $postalCode;
        //realName
        $realName = self::generateRealName($faker, $value);
        $attributes['realName'] = $realName;
        //cellphone
        $cellphone = self::generateCellphone($faker, $value);
        $attributes['cellphone'] = $cellphone;
        //isDefaultAddress
        $isDefaultAddress = self::generateIsDefaultAddress($faker, $value);
        $attributes['isDefaultAddress'] = $isDefaultAddress;
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

        $deliveryAddress['data']['attributes'] = $attributes;

        $deliveryAddress['data']['relationships']['member']['data'] = array(
            'type' => 'members',
            'id' => $faker->randomNumber(1)
        );

        return $deliveryAddress;
    }
    /**
     * [generateDeliveryAddressObject 生成收货地址信息对象]
     * @param  int|integer $id
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]             [地址信息]
     */
    public static function generateDeliveryAddressObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : DeliveryAddress {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $deliveryAddress = new DeliveryAddress($id);

        //area
        $area = self::generateArea($faker, $value);
        $deliveryAddress->setArea($area);
        //address
        $address = self::generateAddress($faker, $value);
        $deliveryAddress->setAddress($address);
        //postalCode
        $postalCode = self::generatePostalCode($faker, $value);
        $deliveryAddress->setPostalCode($postalCode);
        //realName
        $realName = self::generateRealName($faker, $value);
        $deliveryAddress->setRealName($realName);
        //cellphone
        $cellphone = self::generateCellphone($faker, $value);
        $deliveryAddress->setCellphone($cellphone);
        //isDefaultAddress
        $isDefaultAddress = self::generateIsDefaultAddress($faker, $value);
        $deliveryAddress->setIsDefaultAddress($isDefaultAddress);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $deliveryAddress->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $deliveryAddress->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $deliveryAddress->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $deliveryAddress->setStatus($status);
        //member
        $member = self::generateMember($faker, $value);
        $deliveryAddress->setMember($member);

        return $deliveryAddress;
    }

    private static function generateArea($faker, array $value = array())
    {
        return $area = isset($value['area']) ? $value['area'] : '陕西省，西安市，雁塔区';
    }

    private static function generateAddress($faker, array $value = array())
    {
        return $address = isset($value['address']) ?
            $value['address'] : '旺座国际b';
    }

    private static function generatePostalCode($faker, array $value = array())
    {
        return $postalCode = isset($attributes['postalCode']) ?
        $attributes['postalCode'] : '715600';
    }

    private static function generateRealName($faker, array $value = array())
    {
        return $realName = isset($attributes['realName']) ?
        $attributes['realName'] : $faker->name;
    }

    private static function generateCellphone($faker, array $value = array())
    {
        return $cellphone = isset($attributes['cellphone']) ?
        $attributes['cellphone'] : '13202938747';
    }

    private static function generateIsDefaultAddress($faker, array $value = array())
    {
        return $isDefaultAddress = isset($attributes['isDefaultAddress']) ?
        $attributes['isDefaultAddress'] : 0;
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
