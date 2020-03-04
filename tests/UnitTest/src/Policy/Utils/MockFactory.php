<?php
namespace Sdk\Policy\Utils;

use Sdk\Policy\Model\Policy;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generatePolicyArray 生成政策信息数组]
     * @return [array] [政策数组]
     */
    public static function generatePolicyArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $policy = array();

        $policy = array(
            'data'=>array(
                'type'=>'policys',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //title
        $title = self::generateTitle($faker, $value);
        $attributes['title'] = $title;
        //number
        $number = self::generateNumber($faker, $value);
        $attributes['number'] = $number;
        //applicableObjects
        $applicableObjects = self::generateApplicableObjects($faker, $value);
        $attributes['applicableObjects'] = $applicableObjects;
        //applicableIndustries
        $applicableIndustries = self::generateApplicableIndustries($faker, $value);
        $attributes['applicableIndustries'] = $applicableIndustries;
        //level
        /*$level = self::generateLevel($faker, $value);
        $attributes['level'] = $level;*/
        //classifies
        $classifies = self::generateClassifies($faker, $value);
        $attributes['classifies'] = $classifies;
        //detail
        $detail = self::generateDetail($faker, $value);
        $attributes['detail'] = $detail;
        //description
        $description = self::generateDescription($faker, $value);
        $attributes['description'] = $description;
        //image
        $image = self::generateImage($faker, $value);
        $attributes['image'] = $image;
        //attachments
        $attachments = self::generateAttachments($faker, $value);
        $attributes['attachments'] = $attachments;
        //admissibleAddress
        $admissibleAddress = self::generateAdmissibleAddress($faker, $value);
        $attributes['admissibleAddress'] = $admissibleAddress;
        //processingFlow
        $processingFlow = self::generateProcessingFlow($faker, $value);
        $attributes['processingFlow'] = $processingFlow;
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

        $policy['data']['attributes'] = $attributes;
        //crew
        $policy['data']['relationships']['crew']['data'] = array(
            'type' => 'crew',
            'id' => $faker->randomNumber(1)
        );
        //dispatchDepartments
        /*$policy['data']['relationships']['dispatchDepartment']['data'] = array(
            array('type' => 'dispatchDepartment', 'id' => $faker->randomNumber(1)),
            array('type' => 'dispatchDepartment', 'id' => $faker->randomNumber(1))
        );
        //labels
        $policy['data']['relationships']['label']['data'] = array(
            array('type' => 'label', 'id' => $faker->randomNumber(1)),
            array('type' => 'label', 'id' => $faker->randomNumber(1))
        );*/

        return $policy;
    }
    /**
     * [generatePolicyObject 生成政策对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [政策对象]
     */
    public static function generatePolicyObject(int $id = 0, int $seed = 0, array $value = array()) : Policy
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $policy = new Policy($id);

        //title
        $title = self::generateTitle($faker, $value);
        $policy->setTitle($title);
        //number
        $number = self::generateNumber($faker, $value);
        $policy->setNumber($number);
        //applicableObjects
        $applicableObjects = self::generateApplicableObjects($faker, $value);
        $policy->setApplicableObjects($applicableObjects);
        //applicableIndustries
        $applicableIndustries = self::generateApplicableIndustries($faker, $value);
        $policy->setApplicableIndustries($applicableIndustries);
        //level
        /*$level = self::generateLevel($faker, $value);
        $policy->setLevel($level);*/
        //classifies
        $classifies = self::generateClassifies($faker, $value);
        $policy->setClassifies($classifies);
        //detail
        $detail = self::generateDetail($faker, $value);
        $policy->setDetail($detail);
        //description
        $description = self::generateDescription($faker, $value);
        $policy->setDescription($description);
        //image
        $image = self::generateImage($faker, $value);
        $policy->setImage($image);
        //attachments
        $attachments = self::generateAttachments($faker, $value);
        $policy->setAttachments($attachments);
        //admissibleAddress
        $admissibleAddress = self::generateAdmissibleAddress($faker, $value);
        $policy->setAdmissibleAddress($admissibleAddress);
        //processingFlow
        $processingFlow = self::generateProcessingFlow($faker, $value);
        $policy->setProcessingFlow($processingFlow);
        //dispatchDepartments
        /*$dispatchDepartments = self::generateDispatchDepartments($faker, $value);
        $policy->addDispatchDepartments($dispatchDepartments);
        //labels
        $labels = self::generateLabels($faker, $value);
        $policy->addLabels($labels);*/
        //crew
        $crew = self::generateCrew($faker, $value);
        $policy->setCrew($crew);
        //createTime
        $createTime = \Sdk\Common\Utils\MockFactory::generateCreateTime($faker, $value);
        $policy->setCreateTime($createTime);
        //updateTime
        $updateTime = \Sdk\Common\Utils\MockFactory::generateUpdateTime($faker, $value);
        $policy->setUpdateTime($updateTime);
        //statusTime
        $statusTime = \Sdk\Common\Utils\MockFactory::generateStatusTime($faker, $value);
        $policy->setStatusTime($statusTime);
        //status
        $status = \Sdk\Common\Utils\MockFactory::generateStatus($faker, $value);
        $policy->setStatus($status);

        return $policy;
    }

    private static function generateTitle($faker, array $value = array())
    {
        return $title = isset($value['title']) ?
            $value['title'] : $faker->title;
    }

    private static function generateNumber($faker, array $value = array())
    {
        return $number = isset($value['number']) ?
            $value['number'] : $faker->swiftBicNumber;
    }

    private static function generateApplicableObjects($faker, array $value = array())
    {
        return $applicableObjects = isset($value['applicableObjects']) ?
            $value['applicableObjects'] : array(1, 2);
    }

    private static function generateDispatchDepartments($faker, array $value = array())
    {
        return $dispatchDepartments = isset($value['dispatchDepartments']) ?
                $value['dispatchDepartments'] :
                array(\Sdk\DispatchDepartment\Utils\MockFactory::generateDispatchDepartmentObject(
                    $faker->numerify(),
                    $faker->numerify()
                ));
    }

    private static function generateApplicableIndustries($faker, array $value = array())
    {
        return $applicableIndustries = isset($value['applicableIndustries']) ?
            $value['applicableIndustries'] : array(1, 2);
    }

    private static function generateLevel($faker, array $value = array())
    {
        return $level = isset($value['level']) ? $value['level'] :
            \Sdk\Policy\Model\PolicyModelFactory::create(1, \Sdk\Policy\Model\PolicyModelFactory::TYPE['POLICY_LEVEL']);
    }

    private static function generateClassifies($faker, array $value = array())
    {
        return $classifies = isset($value['classifies']) ? $value['classifies'] : array(1, 2);
    }

    private static function generateDetail($faker, array $value = array())
    {
        return $detail = isset($value['detail']) ? $value['detail'] :
           array(
               array('type'=>'text', 'value'=>'This is a detail'),
               array('type'=>'image', 'value'=>'image.png')
           );
    }

    private static function generateDescription($faker, array $value = array())
    {
        return $description = isset($value['description']) ?
            $value['description'] : $faker->text;
    }

    private static function generateImage($faker, array $value = array())
    {
        return $image = isset($value['image']) ?
            $value['image'] : array('name' =>'image', 'identify' => 'image.png');
    }

    private static function generateAttachments($faker, array $value = array())
    {
        return $attachments = isset($value['attachments']) ?
        $value['attachments'] : array(array('name' => $faker->word, 'identify' => $faker->md5));
    }

    private static function generateLabels($faker, array $value = array())
    {
        return $labels = isset($value['labels']) ?
            $value['labels'] : array(\Sdk\Label\Utils\MockFactory::generateLabelObject(0, 0));
    }

    private static function generateAdmissibleAddress($faker, array $value = array())
    {
        return $admissibleAddress = isset($value['admissibleAddress']) ?
            $value['admissibleAddress'] : array(
                    array("address"=>"地址","longitude"=>"12.4","latitude"=>"12.4"),
                    array("address"=>"地址","longitude"=>"12.4","latitude"=>"12.4")
                );
    }

    private static function generateProcessingFlow($faker, array $value = array())
    {
        return $processingFlow = isset($value['processingFlow']) ?
            $value['processingFlow'] : array(array("type"=>"text", "value"=>"办理流程"));
    }

    private static function generateCrew($faker, array $value = array())
    {
        return $crew = isset($value['crew']) ?
            $value['crew'] : \Sdk\Crew\Utils\MockFactory::generateCrewObject($faker->numerify(), $faker->numerify());
    }
}
