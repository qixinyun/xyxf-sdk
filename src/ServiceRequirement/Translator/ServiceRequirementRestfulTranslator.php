<?php
namespace Sdk\ServiceRequirement\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\ServiceRequirement\Model\NullServiceRequirement;
use Sdk\ServiceRequirement\Model\ServiceRequirement;

use Sdk\Member\Translator\MemberRestfulTranslator;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

class ServiceRequirementRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getServiceCategoryRestfulTranslator()
    {
        return new ServiceCategoryRestfulTranslator();
    }

    public function getMemberRestfulTranslator()
    {
        return new MemberRestfulTranslator();
    }

    public function arrayToObject(array $expression, $serviceRequirement = null)
    {
        return $this->translateToObject($expression, $serviceRequirement);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $serviceRequirement = null)
    {
        if (empty($expression)) {
            return NullServiceRequirement::getInstance();
        }

        if ($serviceRequirement == null) {
            $serviceRequirement = new ServiceRequirement();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $serviceRequirement->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['title'])) {
            $serviceRequirement->setTitle($attributes['title']);
        }
        if (isset($attributes['number'])) {
            $serviceRequirement->setNumber($attributes['number']);
        }
        if (isset($attributes['detail'])) {
            $serviceRequirement->setDetail($attributes['detail']);
        }
        if (isset($attributes['minPrice'])) {
            $serviceRequirement->setMinPrice($attributes['minPrice']);
        }
        if (isset($attributes['maxPrice'])) {
            $serviceRequirement->setMaxPrice($attributes['maxPrice']);
        }
        if (isset($attributes['validityStartTime'])) {
            $serviceRequirement->setValidityStartTime($attributes['validityStartTime']);
        }
        if (isset($attributes['validityEndTime'])) {
            $serviceRequirement->setValidityEndTime($attributes['validityEndTime']);
        }
        if (isset($attributes['contactName'])) {
            $serviceRequirement->setContactName($attributes['contactName']);
        }
        if (isset($attributes['contactPhone'])) {
            $serviceRequirement->setContactPhone($attributes['contactPhone']);
        }
        if (isset($attributes['rejectReason'])) {
            $serviceRequirement->setRejectReason($attributes['rejectReason']);
        }
        if (isset($attributes['createTime'])) {
            $serviceRequirement->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $serviceRequirement->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $serviceRequirement->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $serviceRequirement->setStatusTime($attributes['statusTime']);
        }
        if (isset($attributes['applyStatus'])) {
            $serviceRequirement->setApplyStatus($attributes['applyStatus']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['serviceCategory']['data'])) {
            $serviceCategory = $this->changeArrayFormat($relationships['serviceCategory']['data']);
            $serviceRequirement->setServiceCategory(
                $this->getServiceCategoryRestfulTranslator()->arrayToObject($serviceCategory)
            );
        }

        if (isset($relationships['member']['data'])) {
            $member = $this->changeArrayFormat($relationships['member']['data']);
            $serviceRequirement->setMember(
                $this->getMemberRestfulTranslator()->arrayToObject($member)
            );
        }

        return $serviceRequirement;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($serviceRequirement, array $keys = array())
    {
        if (!$serviceRequirement instanceof ServiceRequirement) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'title',
                'detail',
                'minPrice',
                'maxPrice',
                'validityStartTime',
                'validityEndTime',
                'contactName',
                'contactPhone',
                'rejectReason',
                'serviceCategory',
                'member'
            );
        }

        $expression = array(
            'data' => array(
                'type' => 'serviceRequirements'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $serviceRequirement->getId();
        }

        $attributes = array();

        if (in_array('title', $keys)) {
            $attributes['title'] = $serviceRequirement->getTitle();
        }
        if (in_array('detail', $keys)) {
            $attributes['detail'] = $serviceRequirement->getDetail();
        }
        if (in_array('minPrice', $keys)) {
            $attributes['minPrice'] = $serviceRequirement->getMinPrice();
        }
        if (in_array('maxPrice', $keys)) {
            $attributes['maxPrice'] = $serviceRequirement->getMaxPrice();
        }
        if (in_array('validityStartTime', $keys)) {
            $attributes['validityStartTime'] = $serviceRequirement->getValidityStartTime();
        }
        if (in_array('validityEndTime', $keys)) {
            $attributes['validityEndTime'] = $serviceRequirement->getValidityEndTime();
        }
        if (in_array('contactName', $keys)) {
            $attributes['contactName'] = $serviceRequirement->getContactName();
        }
        if (in_array('contactPhone', $keys)) {
            $attributes['contactPhone'] = $serviceRequirement->getContactPhone();
        }
        if (in_array('rejectReason', $keys)) {
            $attributes['rejectReason'] = $serviceRequirement->getRejectReason();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('serviceCategory', $keys)) {
            $expression['data']['relationships']['serviceCategory']['data'] = array(
                array(
                    'type' => 'serviceCategories',
                    'id' => $serviceRequirement->getServiceCategory()->getId()
                )
            );
        }

        if (in_array('member', $keys)) {
            $expression['data']['relationships']['member']['data'] = array(
                array(
                    'type' => 'members',
                    'id' => $serviceRequirement->getMember()->getId()
                )
            );
        }

        return $expression;
    }
}
