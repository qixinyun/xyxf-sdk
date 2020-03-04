<?php
namespace Sdk\Authentication\Translator;

use Marmot\Interfaces\IRestfulTranslator;
use Sdk\Authentication\Model\Authentication;
use Sdk\Authentication\Model\NullAuthentication;
use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\Enterprise\Translator\EnterpriseRestfulTranslator;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

class AuthenticationRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getEnterpriseRestfulTranslator()
    {
        return new EnterpriseRestfulTranslator();
    }

    public function getQualificationRestfulTranslator()
    {
        return new QualificationRestfulTranslator();
    }

    public function getServiceCategoryRestfulTranslator()
    {
        return new ServiceCategoryRestfulTranslator();
    }

    public function arrayToObject(array $expression, $authentication = null)
    {
        return $this->translateToObject($expression, $authentication);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $authentication = null)
    {
        if (empty($expression)) {
            return NullAuthentication::getInstance();
        }

        if ($authentication == null) {
            $authentication = new Authentication();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $authentication->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['number'])) {
            $authentication->setNumber($attributes['number']);
        }
        if (isset($attributes['enterpriseName'])) {
            $authentication->setEnterpriseName($attributes['enterpriseName']);
        }
        if (isset($attributes['qualificationImage'])) {
            $authentication->setQualificationImage($attributes['qualificationImage']);
        }
        if (isset($attributes['rejectReason'])) {
            $authentication->setRejectReason($attributes['rejectReason']);
        }
        if (isset($attributes['createTime'])) {
            $authentication->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $authentication->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $authentication->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $authentication->setStatusTime($attributes['statusTime']);
        }
        if (isset($attributes['applyStatus'])) {
            $authentication->setApplyStatus($attributes['applyStatus']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['serviceCategory']['data'])) {
            $serviceCategory = $this->changeArrayFormat($relationships['serviceCategory']['data']);
            $authentication->setServiceCategory(
                $this->getServiceCategoryRestfulTranslator()->arrayToObject($serviceCategory)
            );
        }

        if (isset($relationships['enterprise']['data'])) {
            $enterprise = $this->changeArrayFormat($relationships['enterprise']['data']);
            $authentication->setEnterprise(
                $this->getEnterpriseRestfulTranslator()->arrayToObject($enterprise)
            );
        }

        return $authentication;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($authentication, array $keys = array())
    {
        if (!$authentication instanceof Authentication) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'enterpriseName',
                'qualificationImage',
                'rejectReason',
                'qualifications',
                'enterprise',
            );
        }

        $expression = array(
            'data' => array(
                'type' => 'authentications',
            ),
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $authentication->getId();
        }

        $attributes = array();

        if (in_array('enterpriseName', $keys)) {
            $attributes['enterpriseName'] = $authentication->getEnterpriseName();
        }

        if (in_array('qualificationImage', $keys)) {
            $attributes['qualificationImage'] = $authentication->getQualificationImage();
        }

        if (in_array('rejectReason', $keys)) {
            $attributes['rejectReason'] = $authentication->getRejectReason();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('qualifications', $keys)) {
            $qualificationsArray = $this->setUpQualificationsArray($authentication);
            $expression['data']['relationships']['qualifications']['data'] = $qualificationsArray;
        }

        if (in_array('enterprise', $keys)) {
            $expression['data']['relationships']['enterprise']['data'] = array(
                array(
                    'type' => 'enterprises',
                    'id' => $authentication->getEnterprise()->getId(),
                ),
            );
        }

        return $expression;
    }

    protected function setUpQualificationsArray(Authentication $authentication)
    {
        $qualificationsArray = [];

        $qualifications = $authentication->getQualifications();
        foreach ($qualifications as $qualificationsKey) {
            $qualificationsArray[] = $this->getQualificationRestfulTranslator()->objectToArray($qualificationsKey);
        }

        return $qualificationsArray;
    }
}
