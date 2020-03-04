<?php
namespace Sdk\Label\Translator;

use Sdk\Label\Model\Label;
use Sdk\Label\Model\NullLabel;
use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\Crew\Translator\CrewRestfulTranslator;

use Marmot\Interfaces\IRestfulTranslator;

class LabelRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    protected function getCrewRestfulTranslator()
    {
        return new CrewRestfulTranslator();
    }

    public function arrayToObject(array $expression, $label = null)
    {
        return $this->translateToObject($expression, $label);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $label = null)
    {
        if (empty($expression)) {
            return NullLabel::getInstance();
        }

        if ($label == null) {
            $label = new Label();
        }
        
        $data =  $expression['data'];

        $id = $data['id'];

        $label->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['name'])) {
            $label->setName($attributes['name']);
        }
        if (isset($attributes['icon'])) {
            $label->setIcon($attributes['icon']);
        }
        if (isset($attributes['category'])) {
            $label->setCategory($attributes['category']);
        }
        if (isset($attributes['remark'])) {
            $label->setRemark($attributes['remark']);
        }
        if (isset($attributes['createTime'])) {
            $label->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $label->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $label->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $label->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['crew']['data'])) {
            $crew = $this->changeArrayFormat($relationships['crew']['data']);
            $label->setCrew($this->getCrewRestfulTranslator()->arrayToObject($crew));
        }

        return $label;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($label, array $keys = array())
    {
        $expression = array();

        if (!$label instanceof Label) {
            return $expression;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
                'icon',
                'category',
                'remark',
                'crew'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'labels'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $label->getId();
        }

        $attributes = array();

        if (in_array('name', $keys)) {
            $attributes['name'] = $label->getName();
        }
        if (in_array('icon', $keys)) {
            $attributes['icon'] = $label->getIcon();
        }
        if (in_array('category', $keys)) {
            $attributes['category'] = $label->getCategory();
        }
        if (in_array('remark', $keys)) {
            $attributes['remark'] = $label->getRemark();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('crew', $keys)) {
            $expression['data']['relationships']['crew']['data'] = array(
                array(
                    'type' => 'crews',
                    'id' => $label->getCrew()->getId()
                )
             );
        }

        return $expression;
    }
}
