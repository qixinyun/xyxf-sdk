<?php
namespace Sdk\ServiceCategory\Translator;

use Sdk\ServiceCategory\Model\ParentCategory;
use Sdk\ServiceCategory\Model\NullParentCategory;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Marmot\Interfaces\IRestfulTranslator;

class ParentCategoryRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $parentCategory = null)
    {
         return $this->translateToObject($expression, $parentCategory);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $parentCategory = null)
    {
        if (empty($expression)) {
            return NullParentCategory::getInstance();
        }

        if ($parentCategory == null) {
            $parentCategory = new ParentCategory();
        }

        $data =  $expression['data'];

        $id = $data['id'];
        $parentCategory->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['name'])) {
            $parentCategory->setName($attributes['name']);
        }
        if (isset($attributes['createTime'])) {
            $parentCategory->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $parentCategory->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $parentCategory->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $parentCategory->setStatusTime($attributes['statusTime']);
        }

        return $parentCategory;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($parentCategory, array $keys = array())
    {
        if (!$parentCategory instanceof ParentCategory) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'name'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'parentCategories'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $parentCategory->getId();
        }

        $attributes = array();

        if (in_array('name', $keys)) {
            $attributes['name'] = $parentCategory->getName();
        }

        $expression['data']['attributes'] = $attributes;

        return $expression;
    }
}
