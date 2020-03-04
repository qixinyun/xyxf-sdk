<?php
namespace Sdk\Policy\Model;

class PolicyModelFactory
{
    const TYPE = array(
        'POLICY_APPLICABLE_OBJECT' => 1,
        'POLICY_APPLICABLELNDUSTRIES' => 2,
        'POLICY_LEVEL' => 3,
        'POLICY_CLASSIFY' => 4
    );
    /**
     * 适用对象
     */
    const POLICY_APPLICABLE_OBJECT = array(
            1 => '微型企业',
            2 => '小型企业',
            3 => '中型企业',
            4 => '大型企业',
            5 => '创业个人',
            6 => '个体商户',
            7 => '其他'
        );
    /**
     * 适用行业
     */
    const POLICY_APPLICABLELNDUSTRIES = array(
            1 => '矿产品（煤、磷）精细化工',
            2 => '生物医学',
            3 => '食品饮料',
            4 => '纺织服装',
            5 => '化学纤维',
            6 => '家具制品',
            7 => '造纸和印刷品',
            8 => '橡胶和塑料',
            9 => '通用设备',
            10 => '专用设备',
            11 => '汽车制造',
            12 => '船舶、航空航天',
            13 => '电气机械',
            14 => '通信电子 仪器仪表',
            15 => '电力、热力供应',
            16 => '其他'
        );
    /**
     * 政策级别
     */
    const POLICY_LEVEL = array(
        1 => '国家级',
        2 => '省级',
        3 => '市级',
        4 => '区级',
        5 => '其他'
    );
    /**
     * 政策分类
     */
    const POLICY_CLASSIFY = array(
        1 => '产业政策',
        2 => '金融支持',
        3 => '环境发展',
        4 => '财政扶持',
        5 => '创业创新',
        6 => '税收优惠',
        7 => '综合政策'
    );

    public static function create(int $id, $type) : PolicyCategory
    {
        switch ($type) {
            case self::TYPE['POLICY_APPLICABLE_OBJECT']:
                $type = self::POLICY_APPLICABLE_OBJECT;
                break;
            case self::TYPE['POLICY_APPLICABLELNDUSTRIES']:
                $type = self::POLICY_APPLICABLELNDUSTRIES;
                break;
            case self::TYPE['POLICY_LEVEL']:
                $type = self::POLICY_LEVEL;
                break;
            case self::TYPE['POLICY_CLASSIFY']:
                $type = self::POLICY_CLASSIFY;
                break;
        }

        return in_array($id, array_keys($type))
            ? new PolicyCategory($id, $type[$id])
            : new NullPolicyCategory(0, '');
    }
}
