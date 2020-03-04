<?php
namespace Sdk\Label\Utils;

use Sdk\Label\Model\Label;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateLabelArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateLabelArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $label = array();

        $label = array(
            'data'=>array(
                'type'=>'labels',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //name
        $name = self::generateName($faker, $value);
        $attributes['name'] = $name;
        //icon
        $icon = self::generateIcon($faker, $value);
        $attributes['icon'] = $icon;
        //category
        $category = self::generateCategory($faker, $value);
        $attributes['category'] = $category;
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

        $label['data']['attributes'] = $attributes;
        //crew
        $label['data']['relationships']['crew']['data'] = array(
            'type' => 'crews',
            'id' => $faker->randomNumber(1)
        );

        return $label;
    }
    /**
     * [generateLabelObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateLabelObject(int $id = 0, int $seed = 0, array $value = array()) : Label
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $label = new Label($id);

        //name
        $name = self::generateName($faker, $value);
        $label->setName($name);
        //icon
        $icon = self::generateIcon($faker, $value);
        $label->setIcon($icon);
        //category
        $category = self::generateCategory($faker, $value);
        $label->setCategory($category);
        //remark
        $remark = self::generateRemark($faker, $value);
        $label->setRemark($remark);
        //crew
        $crew = self::generateCrew($faker, $value);
        $label->setCrew($crew);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $label->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $label->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $label->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $label->setStatus($status);

        return $label;
    }

    private static function generateName($faker, array $value = array())
    {
        return $name = isset($value['name']) ?
        $value['name'] : $faker->name;
    }

    private static function generateIcon($faker, array $value = array())
    {
        return $icon = isset($value['icon']) ?
        $value['icon'] : array('name' => 'icon', 'identify' => 'icon.jpg');
    }

    private static function generateCategory($faker, array $value = array())
    {
        return $category = isset($value['category']) ?
        $value['category'] : $faker->randomElement(
            $array = array(
                Label::CATEAGORY_LABEL['COMMON'],
                Label::CATEAGORY_LABEL['POLICY'],
                Label::CATEAGORY_LABEL['SERVICE']
            )
        );
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
