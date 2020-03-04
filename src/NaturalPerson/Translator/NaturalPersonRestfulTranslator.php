<?php
namespace Sdk\NaturalPerson\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\NaturalPerson\Model\NaturalPerson;
use Sdk\NaturalPerson\Model\IdentityInfo;
use Sdk\NaturalPerson\Model\NullNaturalPerson;

use Sdk\Member\Translator\MemberRestfulTranslator;

class NaturalPersonRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getMemberRestfulTranslator()
    {
        return new MemberRestfulTranslator();
    }

    public function arrayToObject(array $expression, $naturalPerson = null)
    {
        return $this->translateToObject($expression, $naturalPerson);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $naturalPerson = null)
    {
        if (empty($expression)) {
            return NullNaturalPerson::getInstance();
        }

        if ($naturalPerson == null) {
            $naturalPerson = new NaturalPerson();
        }

        $data =  $expression['data'];

        $id = $data['id'];
        $naturalPerson->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['realName'])) {
            $naturalPerson->setRealName($attributes['realName']);
        }
        if (isset($attributes['rejectReason'])) {
            $naturalPerson->setRejectReason($attributes['rejectReason']);
        }
        if (isset($attributes['createTime'])) {
            $naturalPerson->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $naturalPerson->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $naturalPerson->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $naturalPerson->setStatusTime($attributes['statusTime']);
        }
        if (isset($attributes['applyStatus'])) {
            $naturalPerson->setApplyStatus($attributes['applyStatus']);
        }
        $cardId = isset($attributes['cardId'])
        ? $attributes['cardId']
        : '';
        $positivePhoto = isset($attributes['positivePhoto'])
        ? $attributes['positivePhoto']
        : array();
        $reversePhoto = isset($attributes['reversePhoto'])
        ? $attributes['reversePhoto']
        : array();
        $handHeldPhoto = isset($attributes['handheldPhoto'])
        ? $attributes['handheldPhoto']
        : array();

        $naturalPerson->setIdentityInfo(
            new IdentityInfo(
                $cardId,
                $positivePhoto,
                $reversePhoto,
                $handHeldPhoto
            )
        );

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['member']['data'])) {
            $member = $this->changeArrayFormat($relationships['member']['data']);
            $naturalPerson->setMember($this->getMemberRestfulTranslator()->arrayToObject($member));
        }

        return $naturalPerson;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($naturalPerson, array $keys = array())
    {
        if (!$naturalPerson instanceof NaturalPerson) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto',
                'rejectReason',
                'member'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'naturalPersons'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $naturalPerson->getId();
        }

        $attributes = array();

        if (in_array('realName', $keys)) {
            $attributes['realName'] = $naturalPerson->getRealName();
        }
        if (in_array('cardId', $keys)) {
            $attributes['cardId'] = $naturalPerson->getIdentityInfo()->getCardId();
        }
        if (in_array('positivePhoto', $keys)) {
            $attributes['positivePhoto'] = $naturalPerson->getIdentityInfo()->getPositivePhoto();
        }
        if (in_array('reversePhoto', $keys)) {
            $attributes['reversePhoto'] = $naturalPerson->getIdentityInfo()->getReversePhoto();
        }
        if (in_array('handheldPhoto', $keys)) {
            $attributes['handheldPhoto'] = $naturalPerson->getIdentityInfo()->getHandheldPhoto();
        }
        if (in_array('rejectReason', $keys)) {
            $attributes['rejectReason'] = $naturalPerson->getRejectReason();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('member', $keys)) {
            $expression['data']['relationships']['member']['data'] = array(
                array(
                    'type' => 'members',
                    'id' => $naturalPerson->getMember()->getId()
                )
             );
        }

        return $expression;
    }
}
