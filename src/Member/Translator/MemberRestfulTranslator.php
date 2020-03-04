<?php
namespace Sdk\Member\Translator;

use Sdk\Member\Model\Member;
use Sdk\Member\Model\NullMember;
use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\User\Translator\UserRestfulTranslator;

class MemberRestfulTranslator extends UserRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $member = null)
    {
        return $this->translateToObject($expression, $member);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function translateToObject(array $expression, $member = null)
    {
        if (empty($expression)) {
            return NullMember::getInstance();
        }

        if ($member == null) {
            $member = new Member();
        }

        $member = parent::translateToObject($expression, $member);

        $data =  $expression['data'];

        $attributes = isset($data['attributes']) ? $data['attributes'] : array();

        if (isset($attributes['nickName'])) {
            $member->setNickName($attributes['nickName']);
        }
        if (isset($attributes['birthday'])) {
            $member->setBirthday($attributes['birthday']);
        }
        if (isset($attributes['area'])) {
            $member->setArea($attributes['area']);
        }
        if (isset($attributes['address'])) {
            $member->setAddress($attributes['address']);
        }
        if (isset($attributes['briefIntroduction'])) {
            $member->setBriefIntroduction($attributes['briefIntroduction']);
        }

        return $member;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($member, array $keys = array())
    {
        $user = parent::objectToArray($member, $keys);
        
        if (!$member instanceof Member) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'nickName',
                'birthday',
                'area',
                'address',
                'briefIntroduction'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'members',
                'id'=>$member->getId()
            )
        );

        $attributes = array();

        if (in_array('nickName', $keys)) {
            $attributes['nickName'] = $member->getNickName();
        }
        if (in_array('birthday', $keys)) {
            $attributes['birthday'] = $member->getBirthday();
        }
        if (in_array('area', $keys)) {
            $attributes['area'] = $member->getArea();
        }
        if (in_array('address', $keys)) {
            $attributes['address'] = $member->getAddress();
        }
        if (in_array('briefIntroduction', $keys)) {
            $attributes['briefIntroduction'] = $member->getBriefIntroduction();
        }

        $expression['data']['attributes'] = array_merge($user['data']['attributes'], $attributes);

        return $expression;
    }
}
