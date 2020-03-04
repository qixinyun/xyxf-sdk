<?php
namespace Sdk\Policy\Translator;

use Sdk\Policy\Model\Policy;
use Sdk\Policy\Model\NullPolicy;
use Sdk\Policy\Model\PolicyModelFactory;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\Crew\Translator\CrewRestfulTranslator;

use Sdk\Label\Translator\LabelRestfulTranslator;

use Sdk\DispatchDepartment\Translator\DispatchDepartmentRestfulTranslator;

use Marmot\Interfaces\IRestfulTranslator;

class PolicyRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait, PolicyRestfulTranslatorTrait;

    public function getCrewRestfulTranslator()
    {
        return new CrewRestfulTranslator();
    }

    public function getLabelRestfulTranslator()
    {
        return new LabelRestfulTranslator();
    }

    public function getDispatchDepartmentRestfulTranslator()
    {
        return new DispatchDepartmentRestfulTranslator();
    }

    public function arrayToObject(array $expression, $policy = null)
    {
        return $this->translateToObject($expression, $policy);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $policy = null)
    {
        if (empty($expression)) {
            return NullPolicy::getInstance();
        }
        if ($policy === null) {
            $policy = new Policy();
        }
        
        $data =  $expression['data'];
        $id = $data['id'];
        $policy->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['title'])) {
            $policy->setTitle($attributes['title']);
        }
        if (isset($attributes['number'])) {
            $policy->setNumber($attributes['number']);
        }
        if (isset($attributes['applicableObjects'])) {
            $applicableObjects = $this->setUpApplicableObjects($attributes['applicableObjects']);
            $policy->setApplicableObjects($applicableObjects);
        }
        if (isset($attributes['applicableIndustries'])) {
            $applicableIndustries = $this->setUpApplicableIndustries($attributes['applicableIndustries']);
            $policy->setApplicableIndustries($applicableIndustries);
        }
        if (isset($attributes['level'])) {
            $policy->setLevel(PolicyModelFactory::create(
                $attributes['level'],
                PolicyModelFactory::TYPE['POLICY_LEVEL']
            ));
        }
        if (isset($attributes['classifies'])) {
            $classifies = $this->setUpClassifies($attributes['classifies']);
            $policy->setClassifies($classifies);
        }
        if (isset($attributes['detail'])) {
            $policy->setDetail($attributes['detail']);
        }
        if (isset($attributes['description'])) {
            $policy->setDescription($attributes['description']);
        }
        if (isset($attributes['image'])) {
            $policy->setImage($attributes['image']);
        }
        if (isset($attributes['attachments'])) {
            $policy->setAttachments($attributes['attachments']);
        }
        if (isset($attributes['admissibleAddress'])) {
            $policy->setAdmissibleAddress($attributes['admissibleAddress']);
        }
        if (isset($attributes['processingFlow'])) {
            $policy->setProcessingFlow($attributes['processingFlow']);
        }
        if (isset($attributes['statusTime'])) {
            $policy->setStatusTime($attributes['statusTime']);
        }
        if (isset($attributes['createTime'])) {
            $policy->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $policy->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $policy->setStatus($attributes['status']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['crew']['data'])) {
            $crew = $this->changeArrayFormat($relationships['crew']['data']);
            $policy->setCrew($this->getCrewRestfulTranslator()->arrayToObject($crew));
        }
        if (isset($relationships['dispatchDepartments']['data'])) {
            $this->setUpDispatchDepartments($relationships['dispatchDepartments']['data'], $policy);
        }
        if (isset($relationships['labels']['data'])) {
            $this->setUpLabels($relationships['labels']['data'], $policy);
        }

        return $policy;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($policy, array $keys = array())
    {
        $expression = array();

        if (!$policy instanceof Policy) {
            return $expression;
        }

        if (empty($keys)) {
            $keys = array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress',
                'crew'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'policies'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $policy->getId();
        }

        $attributes = array();

        if (in_array('title', $keys)) {
            $attributes['title'] = $policy->getTitle();
        }
        if (in_array('number', $keys)) {
            $attributes['number'] = $policy->getNumber();
        }
        if (in_array('applicableObjects', $keys)) {
            $attributes['applicableObjects'] = $policy->getApplicableObjects();
        }
        if (in_array('applicableIndustries', $keys)) {
            $attributes['applicableIndustries'] = $policy->getApplicableIndustries();
        }
        if (in_array('level', $keys)) {
            $attributes['level'] = $policy->getLevel()->getId();
        }
        if (in_array('classifies', $keys)) {
            $attributes['classifies'] = $policy->getClassifies();
        }
        if (in_array('detail', $keys)) {
            $attributes['detail'] = $policy->getDetail();
        }
        if (in_array('description', $keys)) {
            $attributes['description'] = $policy->getDescription();
        }
        if (in_array('image', $keys)) {
            $attributes['image'] = $policy->getImage();
        }
        if (in_array('attachments', $keys)) {
            $attributes['attachments'] = $policy->getAttachments();
        }
        if (in_array('processingFlow', $keys)) {
            $attributes['processingFlow'] = $policy->getProcessingFlow();
        }
        if (in_array('admissibleAddress', $keys)) {
            $attributes['admissibleAddress'] = $policy->getAdmissibleAddress();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('crew', $keys)) {
            $expression['data']['relationships']['crew']['data'] = array(
                array(
                    'type' => 'crews',
                    'id' => $policy->getCrew()->getId()
                )
            );
        }
        if (in_array('dispatchDepartments', $keys)) {
            $dispatchDepartmentsArray = $this->setUpDispatchDepartmentsArray($policy);
            $expression['data']['relationships']['dispatchDepartments']['data'] = $dispatchDepartmentsArray;
        }
        if (in_array('labels', $keys)) {
            $labelsArray = $this->setUpLabelsArray($policy);
            $expression['data']['relationships']['labels']['data'] = $labelsArray;
        }

        return $expression;
    }
}
