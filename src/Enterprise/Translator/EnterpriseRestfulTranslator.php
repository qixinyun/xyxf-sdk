<?php
namespace Sdk\Enterprise\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Model\LegalPersonInfo;
use Sdk\Enterprise\Model\ContactsInfo;
use Sdk\Enterprise\Model\NullEnterprise;

use Sdk\Member\Translator\MemberRestfulTranslator;

/**
 * 屏蔽类中所有PMD警告
 *
 * @SuppressWarnings(PHPMD)
 */
class EnterpriseRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getMemberRestfulTranslator()
    {
        return new MemberRestfulTranslator();
    }

    public function arrayToObject(array $expression, $enterprise = null)
    {
        return $this->translateToObject($expression, $enterprise);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $enterprise = null)
    {
        if (empty($expression)) {
            return NullEnterprise::getInstance();
        }

        if ($enterprise == null) {
            $enterprise = new Enterprise();
        }

        $data =  $expression['data'];

        $id = $data['id'];
        $enterprise->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['name'])) {
            $enterprise->setName($attributes['name']);
        }
        if (isset($attributes['unifiedSocialCreditCode'])) {
            $enterprise->setUnifiedSocialCreditCode($attributes['unifiedSocialCreditCode']);
        }
        if (isset($attributes['logo'])) {
            $enterprise->setLogo($attributes['logo']);
        }
        if (isset($attributes['businessLicense'])) {
            $enterprise->setBusinessLicense($attributes['businessLicense']);
        }
        if (isset($attributes['powerAttorney'])) {
            $enterprise->setPowerAttorney($attributes['powerAttorney']);
        }

        $contactsName = isset($attributes['contactsName'])
        ? $attributes['contactsName']
        : '';
        $contactsCellphone = isset($attributes['contactsCellphone'])
        ? $attributes['contactsCellphone']
        : '';
        $contactsArea = isset($attributes['contactsArea'])
        ? $attributes['contactsArea']
        : '';
        $contactsAddress = isset($attributes['contactsAddress'])
        ? $attributes['contactsAddress']
        : '';
        $enterprise->setContactsInfo(
            new ContactsInfo(
                $contactsName,
                $contactsCellphone,
                $contactsArea,
                $contactsAddress
            )
        );

        $legalPersonName = isset($attributes['legalPersonName'])
        ? $attributes['legalPersonName']
        : '';
        $legalPersonCardId = isset($attributes['legalPersonCardId'])
        ? $attributes['legalPersonCardId']
        : '';
        $legalPersonPositivePhoto = isset($attributes['legalPersonPositivePhoto'])
        ? $attributes['legalPersonPositivePhoto']
        : array();
        $legalPersonReversePhoto = isset($attributes['legalPersonReversePhoto'])
        ? $attributes['legalPersonReversePhoto']
        : array();
        $legalPersonHandheldPhoto = isset($attributes['legalPersonHandheldPhoto'])
        ? $attributes['legalPersonHandheldPhoto']
        : array();
        $enterprise->setLegalPersonInfo(
            new LegalPersonInfo(
                $legalPersonName,
                $legalPersonCardId,
                $legalPersonPositivePhoto,
                $legalPersonReversePhoto,
                $legalPersonHandheldPhoto
            )
        );
        if (isset($attributes['createTime'])) {
            $enterprise->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $enterprise->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $enterprise->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $enterprise->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['member']['data'])) {
            $member = $this->changeArrayFormat($relationships['member']['data']);
            $enterprise->setMember($this->getMemberRestfulTranslator()->arrayToObject($member));
        }

        return $enterprise;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($enterprise, array $keys = array())
    {
        if (!$enterprise instanceof Enterprise) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'name',
                'unifiedSocialCreditCode',
                'logo',
                'businessLicense',
                'powerAttorney',
                'contactsName',
                'contactsCellphone',
                'contactsArea',
                'contactsAddress',
                'legalPersonName',
                'legalPersonCardId',
                'legalPersonPositivePhoto',
                'legalPersonReversePhoto',
                'legalPersonHandheldPhoto',
                'member'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'enterprises'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $enterprise->getId();
        }

        $attributes = array();

        if (in_array('name', $keys)) {
            $attributes['name'] = $enterprise->getName();
        }
        if (in_array('unifiedSocialCreditCode', $keys)) {
            $attributes['unifiedSocialCreditCode'] = $enterprise->getUnifiedSocialCreditCode();
        }
        if (in_array('logo', $keys)) {
            $attributes['logo'] = $enterprise->getLogo();
        }
        if (in_array('businessLicense', $keys)) {
            $attributes['businessLicense'] = $enterprise->getBusinessLicense();
        }
        if (in_array('powerAttorney', $keys)) {
            $attributes['powerAttorney'] = $enterprise->getPowerAttorney();
        }
        if (in_array('contactsName', $keys)) {
            $attributes['contactsName'] = $enterprise->getContactsInfo()->getName();
        }
        if (in_array('contactsCellphone', $keys)) {
            $attributes['contactsCellphone'] = $enterprise->getContactsInfo()->getCellphone();
        }
        if (in_array('contactsArea', $keys)) {
            $attributes['contactsArea'] = $enterprise->getContactsInfo()->getArea();
        }
        if (in_array('contactsAddress', $keys)) {
            $attributes['contactsAddress'] = $enterprise->getContactsInfo()->getAddress();
        }
        if (in_array('legalPersonName', $keys)) {
            $attributes['legalPersonName'] = $enterprise->getLegalPersonInfo()->getName();
        }
        if (in_array('legalPersonCardId', $keys)) {
            $attributes['legalPersonCardId'] = $enterprise->getLegalPersonInfo()->getCardId();
        }
        if (in_array('legalPersonPositivePhoto', $keys)) {
            $attributes['legalPersonPositivePhoto'] = $enterprise->getLegalPersonInfo()->getPositivePhoto();
        }
        if (in_array('legalPersonReversePhoto', $keys)) {
            $attributes['legalPersonReversePhoto'] = $enterprise->getLegalPersonInfo()->getReversePhoto();
        }
        if (in_array('legalPersonHandheldPhoto', $keys)) {
            $attributes['legalPersonHandheldPhoto'] = $enterprise->getLegalPersonInfo()->getHandheldPhoto();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('member', $keys)) {
            $expression['data']['relationships']['member']['data'] = array(
                array(
                    'type' => 'members',
                    'id' => $enterprise->getMember()->getId()
                )
             );
        }

        return $expression;
    }
}
