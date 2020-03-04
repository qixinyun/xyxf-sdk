<?php
namespace Sdk\Enterprise\Translator;

use Sdk\Enterprise\Model\UnAuditedEnterprise;
use Sdk\Enterprise\Model\NullUnAuditedEnterprise;

class UnAuditedEnterpriseRestfulTranslator extends EnterpriseRestfulTranslator
{
    public function arrayToObject(array $expression, $unAuditedEnterprise = null)
    {
        return $this->translateToObject($expression, $unAuditedEnterprise);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $unAuditedEnterprise = null)
    {
        if (empty($expression)) {
            return NullUnAuditedEnterprise::getInstance();
        }

        if ($unAuditedEnterprise == null) {
            $unAuditedEnterprise = new UnAuditedEnterprise();
        }

        $unAuditedEnterprise = parent::translateToObject($expression, $unAuditedEnterprise);

        $data =  $expression['data'];

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['rejectReason'])) {
            $unAuditedEnterprise->setRejectReason($attributes['rejectReason']);
        }

        if (isset($attributes['applyStatus'])) {
            $unAuditedEnterprise->setApplyStatus($attributes['applyStatus']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['relation']['data'])) {
            $relation = $this->changeArrayFormat($relationships['relation']['data']);
            $unAuditedEnterprise->setMember($this->getMemberRestfulTranslator()->arrayToObject($relation));
        }

        return $unAuditedEnterprise;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($unAuditedEnterprise, array $keys = array())
    {
        $enterprise = parent::objectToArray($unAuditedEnterprise, $keys);
        
        if (!$unAuditedEnterprise instanceof UnAuditedEnterprise) {
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
                'rejectReason'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'unAuditedEnterprises'
            )
        );

        $attributes = array();

        if (in_array('rejectReason', $keys)) {
            $attributes['rejectReason'] = $unAuditedEnterprise->getRejectReason();
        }

        $expression['data']['attributes'] = array_merge($enterprise['data']['attributes'], $attributes);

        return $expression;
    }
}
