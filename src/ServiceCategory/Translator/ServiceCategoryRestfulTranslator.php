<?php
namespace Sdk\ServiceCategory\Translator;

use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Model\NullServiceCategory;
use Sdk\ServiceCategory\Translator\ParentCategoryRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Marmot\Interfaces\IRestfulTranslator;

class ServiceCategoryRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getParentCategoryRestfulTranslator()
    {
        return new ParentCategoryRestfulTranslator();
    }

    public function arrayToObject(array $expression, $serviceCategory = null)
    {
         return $this->translateToObject($expression, $serviceCategory);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $serviceCategory = null)
    {
        if (empty($expression)) {
            return NullServiceCategory::getInstance();
        }

        if ($serviceCategory == null) {
            $serviceCategory = new ServiceCategory();
        }

        $data =  $expression['data'];

        $id = $data['id'];
        $serviceCategory->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['name'])) {
            $serviceCategory->setName($attributes['name']);
        }
        if (isset($attributes['isQualification'])) {
            $serviceCategory->setIsQualification($attributes['isQualification']);
        }
        if (isset($attributes['qualificationName'])) {
            $serviceCategory->setQualificationName($attributes['qualificationName']);
        }
        if (isset($attributes['commission'])) {
            $serviceCategory->setCommission($attributes['commission']);
        }
        if (isset($attributes['createTime'])) {
            $serviceCategory->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $serviceCategory->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $serviceCategory->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $serviceCategory->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['parentCategory']['data'])) {
            $parentCategory = $this->changeArrayFormat($relationships['parentCategory']['data']);
            $serviceCategory->setParentCategory(
                $this->getParentCategoryRestfulTranslator()->arrayToObject($parentCategory)
            );
        }

        return $serviceCategory;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($serviceCategory, array $keys = array())
    {
        if (!$serviceCategory instanceof ServiceCategory) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'name',
                'parentCategory',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'serviceCategories'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $serviceCategory->getId();
        }

        $attributes = array();

        if (in_array('name', $keys)) {
            $attributes['name'] = $serviceCategory->getName();
        }

        if (in_array('isQualification', $keys)) {
            $attributes['isQualification'] = $serviceCategory->getIsQualification();
        }

        if (in_array('qualificationName', $keys)) {
            $attributes['qualificationName'] = $serviceCategory->getQualificationName();
        }

        if (in_array('commission', $keys)) {
            $attributes['commission'] = $serviceCategory->getCommission();
        }

        if (in_array('status', $keys)) {
            $attributes['status'] = $serviceCategory->getStatus();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('parentCategory', $keys)) {
            $expression['data']['relationships']['parentCategory']['data'] = array(
                array(
                    'type' => 'parentCategories',
                    'id' => $serviceCategory->getParentCategory()->getId()
                )
             );
        }

        return $expression;
    }
}
