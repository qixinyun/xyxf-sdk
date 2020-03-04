<?php
namespace Sdk\PolicyInterpretation\Translator;

use Sdk\PolicyInterpretation\Model\PolicyInterpretation;
use Sdk\PolicyInterpretation\Model\NullPolicyInterpretation;
use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\Crew\Translator\CrewRestfulTranslator;
use Sdk\Policy\Translator\PolicyRestfulTranslator;

use Marmot\Interfaces\IRestfulTranslator;

/**
 * 屏蔽类中所有PMD警告
 *
 * @SuppressWarnings(PHPMD)
 */
class PolicyInterpretationRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    protected function getCrewRestfulTranslator()
    {
        return new CrewRestfulTranslator();
    }

    protected function getPolicyRestfulTranslator()
    {
        return new PolicyRestfulTranslator();
    }

    public function arrayToObject(array $expression, $policyInterpretationRestfulTranslator = null)
    {
        return $this->translateToObject($expression, $policyInterpretationRestfulTranslator);
    }

    protected function translateToObject(array $expression, $policyInterpretation = null)
    {
        if (empty($expression)) {
            return NullPolicyInterpretation::getInstance();
        }
        if ($policyInterpretation === null) {
            $policyInterpretation = new PolicyInterpretation();
        }
        
        $data =  $expression['data'];
        $id = $data['id'];
        $policyInterpretation->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['cover'])) {
            $policyInterpretation->setCover($attributes['cover']);
        }
        if (isset($attributes['title'])) {
            $policyInterpretation->setTitle($attributes['title']);
        }
        if (isset($attributes['detail'])) {
            $policyInterpretation->setDetail($attributes['detail']);
        }
        if (isset($attributes['description'])) {
            $policyInterpretation->setDescription($attributes['description']);
        }
        if (isset($attributes['attachments'])) {
            $policyInterpretation->setAttachments($attributes['attachments']);
        }
        if (isset($attributes['statusTime'])) {
            $policyInterpretation->setStatusTime($attributes['statusTime']);
        }
        if (isset($attributes['createTime'])) {
            $policyInterpretation->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $policyInterpretation->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $policyInterpretation->setStatus($attributes['status']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['crew']['data'])) {
            $crew = $this->changeArrayFormat($relationships['crew']['data']);
            $policyInterpretation->setCrew($this->getCrewRestfulTranslator()->arrayToObject($crew));
        }
        if (isset($relationships['policy']['data'])) {
            if (isset($expression['included'])) {
                $policy = $this->changeArrayFormat($relationships['policy']['data'], $expression['included']);
            }
            if (!isset($expression['included'])) {
                $policy = $this->changeArrayFormat($relationships['policy']['data']);
            }
            $policyInterpretation->setPolicy($this->getPolicyRestfulTranslator()->arrayToObject($policy));
        }

        return $policyInterpretation;
    }

    public function objectToArray($policyInterpretation, array $keys = array())
    {
        $expression = array();

        if (!$policyInterpretation instanceof PolicyInterpretation) {
            return $expression;
        }

        if (empty($keys)) {
            $keys = array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments',
                'crew'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'policyInterpretations'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $policyInterpretation->getId();
        }

        $attributes = array();

        if (in_array('cover', $keys)) {
            $attributes['cover'] = $policyInterpretation->getCover();
        }
        if (in_array('title', $keys)) {
            $attributes['title'] = $policyInterpretation->getTitle();
        }
        if (in_array('detail', $keys)) {
            $attributes['detail'] = $policyInterpretation->getDetail();
        }
        if (in_array('description', $keys)) {
            $attributes['description'] = $policyInterpretation->getDescription();
        }
        if (in_array('attachments', $keys)) {
            $attributes['attachments'] = $policyInterpretation->getAttachments();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('crew', $keys)) {
            $expression['data']['relationships']['crew']['data'] = array(
                array(
                    'type' => 'crews',
                    'id' => $policyInterpretation->getCrew()->getId()
                )
            );
        }
        if (in_array('policy', $keys)) {
            $expression['data']['relationships']['policy']['data'] = array(
                array(
                    'type' => 'policies',
                    'id' => $policyInterpretation->getPolicy()->getId()
                )
            );
        }

        return $expression;
    }
}
