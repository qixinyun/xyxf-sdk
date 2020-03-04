<?php
namespace Sdk\Enterprise\Utils;

use Sdk\Enterprise\Model\UnAuditedEnterprise;

use Sdk\Common\Model\IApplyAble;

class UnAuditedEnterpriseMockFactory
{
    /**
     * [generateEnterpriseArray 生成用户信息数组]
     * @return [array] [用户数组]
     */
    public static function generateUnAuditedEnterpriseArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $unAuditedEnterprise = array();

        $unAuditedEnterprise = array(
            'data'=>array(
                'type'=>'enterprises',
                'id'=>$faker->randomNumber(2)
            )
        );
        
        $value = array();
        $attributes = array();

        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $attributes['rejectReason'] = $rejectReason;

        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $attributes['applyStatus'] = $applyStatus;

        $enterprise = \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseArray();

        $unAuditedEnterprise['data']['attributes'] = array_merge($enterprise['data']['attributes'], $attributes);

        $unAuditedEnterprise['data']['relationships'] = $enterprise['data']['relationships'];
        
        return $unAuditedEnterprise;
    }

    /**
     * [generateEnterpriseObject 生成用户对象对象]
     * @param  int|integer $id    [用户Id]
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]           [用户对象]
     */
    public static function generateUnAuditedEnterpriseObject(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : UnAuditedEnterprise {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $unAuditedEnterprise = new UnAuditedEnterprise($id);

        $unAuditedEnterprise =
            \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseObject($unAuditedEnterprise);

        //rejectReason
        $rejectReason = self::generateRejectReason($faker, $value);
        $unAuditedEnterprise->setRejectReason($rejectReason);

        //applyStatus
        $applyStatus = self::generateApplyStatus($faker, $value);
        $unAuditedEnterprise->setApplyStatus($applyStatus);

        return $unAuditedEnterprise;
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
            IApplyAble::APPLY_STATUS
        );
    }
}
