<?php
namespace Sdk\DispatchDepartment\Translator;

use Sdk\DispatchDepartment\Model\DispatchDepartment;
use Sdk\DispatchDepartment\Model\NullDispatchDepartment;
use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\Crew\Translator\CrewRestfulTranslator;

use Marmot\Interfaces\IRestfulTranslator;

class DispatchDepartmentRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    protected function getCrewRestfulTranslator()
    {
        return new CrewRestfulTranslator();
    }

    public function arrayToObject(array $expression, $dispatchDepartment = null)
    {
        return $this->translateToObject($expression, $dispatchDepartment);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $dispatchDepartment = null)
    {
        if (empty($expression)) {
            return NullDispatchDepartment::getInstance();
        }

        if ($dispatchDepartment == null) {
            $dispatchDepartment = new DispatchDepartment();
        }

        $data =  $expression['data'];

        $id = $data['id'];

        $dispatchDepartment->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['name'])) {
            $dispatchDepartment->setName($attributes['name']);
        }
        if (isset($attributes['remark'])) {
            $dispatchDepartment->setRemark($attributes['remark']);
        }
        if (isset($attributes['createTime'])) {
            $dispatchDepartment->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $dispatchDepartment->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $dispatchDepartment->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $dispatchDepartment->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['crew']['data'])) {
            $crew = $this->changeArrayFormat($relationships['crew']['data']);
            $dispatchDepartment->setCrew($this->getCrewRestfulTranslator()->arrayToObject($crew));
        }

        return $dispatchDepartment;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($dispatchDepartment, array $keys = array())
    {
        $expression = array();

        if (!$dispatchDepartment instanceof DispatchDepartment) {
            return $expression;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
                'remark',
                'status',
                'crew'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'dispatchDepartments'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $dispatchDepartment->getId();
        }

        $attributes = array();

        if (in_array('name', $keys)) {
            $attributes['name'] = $dispatchDepartment->getName();
        }

        if (in_array('remark', $keys)) {
            $attributes['remark'] = $dispatchDepartment->getRemark();
        }

        if (in_array('status', $keys)) {
            $attributes['status'] = $dispatchDepartment->getStatus();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('crew', $keys)) {
            $expression['data']['relationships']['crew']['data'] = array(
                array(
                    'type' => 'crews',
                    'id' => $dispatchDepartment->getCrew()->getId()
                )
             );
        }

        return $expression;
    }
}
