<?php
namespace Sdk\PolicyInterpretation\Utils;

use Sdk\PolicyInterpretation\Model\PolicyInterpretation;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generatePolicyInterpretationArray 生成政策解读数组]
     * @return [array] [政策解读数组]
     */
    public static function generatePolicyInterpretationArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $policyInterpretation = array();

        $policyInterpretation = array(
            'data'=>array(
                'type'=>'policyInterpretations',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //cover
        $cover = self::generateCover($faker, $value);
        $attributes['cover'] = $cover;
        //title
        $title = self::generateTitle($faker, $value);
        $attributes['title'] = $title;
        //detail
        $detail = self::generateDetail($faker, $value);
        $attributes['detail'] = $detail;
        //description
        $description = self::generateDescription($faker, $value);
        $attributes['description'] = $description;
        //attachments
        $attachments = self::generateAttachments($faker, $value);
        $attributes['attachments'] = $attachments;
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

        $policyInterpretation['data']['attributes'] = $attributes;
        //crew
        $policyInterpretation['data']['relationships']['crew']['data'] = array(
            'type' => 'crews',
            'id' => $faker->randomNumber(1)
        );
        //policy
        $policyInterpretation['data']['relationships']['policy']['data'] = array(
            'type' => 'policies',
            'id' => $faker->randomNumber(1)
        );

        return $policyInterpretation;
    }
    /**
     * [generatePolicyInterpretationObject 生成政策解读对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [政策解读对象]
     */
    public static function generatePolicyInterpretationObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : PolicyInterpretation {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $policyInterpretation = new PolicyInterpretation($id);

        //cover
        $cover = self::generateCover($faker, $value);
        $policyInterpretation->setCover($cover);
        //title
        $title = self::generateTitle($faker, $value);
        $policyInterpretation->setTitle($title);
        //detail
        $detail = self::generateDetail($faker, $value);
        $policyInterpretation->setDetail($detail);
        //description
        $description = self::generateDescription($faker, $value);
        $policyInterpretation->setDescription($description);
        //attachments
        $attachments = self::generateAttachments($faker, $value);
        $policyInterpretation->setAttachments($attachments);
        //crew
        $crew = self::generateCrew($faker, $value);
        $policyInterpretation->setCrew($crew);
        //policy
        $policy = self::generatePolicy($faker, $value);
        $policyInterpretation->setPolicy($policy);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $policyInterpretation->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $policyInterpretation->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $policyInterpretation->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $policyInterpretation->setStatus($status);

        return $policyInterpretation;
    }

    private static function generateCover($faker, array $value = array())
    {
        return $cover = isset($value['cover']) ?
            $value['cover'] : array('name' =>'cover', 'identify' => 'cover.jpg');
    }

    private static function generateTitle($faker, array $value = array())
    {
        return $title = isset($value['title']) ?
            $value['title'] : $faker->title;
    }

    private static function generateDetail($faker, array $value = array())
    {
        return $detail = isset($value['detail']) ? $value['detail'] :
           array(
               array('type'=>'text', 'value'=>'This is a detail'),
               array('type'=>'image', 'value'=>'image.jpg')
           );
    }

    private static function generateDescription($faker, array $value = array())
    {
        return $description = isset($value['description']) ?
            $value['description'] : $faker->text;
    }

    private static function generateAttachments($faker, array $value = array())
    {
        return $attachments = isset($value['attachments']) ?
        $value['attachments'] : array(array('name' => $faker->word, 'identify' => $faker->md5));
    }

    private static function generateCrew($faker, array $value = array())
    {
        return $crew = isset($value['crew']) ?
            $value['crew'] : \Sdk\Crew\Utils\MockFactory::generateCrewObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }

    private static function generatePolicy($faker, array $value = array())
    {
        return $policy = isset($value['policy']) ?
            $value['policy'] : \Sdk\Policy\Utils\MockFactory::generatePolicyObject(
                $faker->numerify(),
                $faker->numerify()
            );
    }
}
