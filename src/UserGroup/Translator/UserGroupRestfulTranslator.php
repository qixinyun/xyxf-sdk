<?php
namespace Sdk\UserGroup\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\UserGroup\Model\JurisdictionColumnModelFactory;
use Sdk\UserGroup\Model\UserGroup;
use Sdk\UserGroup\Model\NullUserGroup;
use Sdk\UserGroup\Model\CategoryModelFactory;

class UserGroupRestfulTranslator implements IRestfulTranslator
{
    public function arrayToObject(array $expression, $userGroup = null)
    {
        return $this->translateToObject($expression, $userGroup);
    }

    public function arrayToObjects(array $expression) : array
    {
        if (empty($expression)) {
            return array(0,array());
        }

        if (isset($expression['data'][0])) {
            $result = array();
            foreach ($expression['data'] as $each) {
                $each['data'] = $each;
                if (isset($expression['included'])) {
                    $each['included'] = $expression['included'];
                }
                $result[$each['id']] = $this->translateToObject($each);
            }

            $count = isset($expression['meta']['count']) ? $expression['meta']['count'] : sizeof($result);
            return [$count, $result];
        }

        return [1, [$expression['data']['id']=>$this->translateToObject($expression)]];
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $userGroup = null)
    {
        if (empty($expression)) {
            return new NullUserGroup();
        }

        if ($userGroup == null) {
            $userGroup = new UserGroup();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $userGroup->setId($id);

        if (isset($data['attributes'])) {
            $attributes = $data['attributes'];

            if (isset($attributes['name'])) {
                $userGroup->setName($attributes['name']);
            }
            if (isset($attributes['shortName'])) {
                $userGroup->setShortName($attributes['shortName']);
            }
            if (isset($attributes['createTime'])) {
                $userGroup->setCreateTime($attributes['createTime']);
            }
            if (isset($attributes['updateTime'])) {
                $userGroup->setUpdateTime($attributes['updateTime']);
            }
            if (isset($attributes['jurisdictionColumns'])) {
                foreach ($attributes['jurisdictionColumns'] as $each) {
                    $userGroup->addJurisdictionColumn(JurisdictionColumnModelFactory::create($each));
                }
            }
            if (isset($attributes['administrativeArea'])) {
                $userGroup->setAdministrativeArea(
                    CategoryModelFactory::create($attributes['administrativeArea'])
                );
            }
            if (isset($attributes['status'])) {
                $userGroup->setStatus($attributes['status']);
            }
            if (isset($attributes['statusTime'])) {
                $userGroup->setStatusTime($attributes['statusTime']);
            }
        }

        return $userGroup;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($userGroup, array $keys = array())
    {
        if (!$userGroup instanceof UserGroup) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
                'shortName',
                'jurisdictionColumns',
                'administrativeArea'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'userGroups'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $userGroup->getId();
        }

        $attributes = array();
        if (in_array('name', $keys)) {
            $attributes['name'] = $userGroup->getName();
        }
        if (in_array('shortName', $keys)) {
            $attributes['shortName'] = $userGroup->getShortName();
        }
        if (in_array('jurisdictionColumns', $keys)) {
            $attributes['jurisdictionColumns'] = array();
            $jurisdictionColumns = $userGroup->getJurisdictionColumns();
            if (!empty($jurisdictionColumns)) {
                foreach ($jurisdictionColumns as $jurisdictionColumn) {
                    $attributes['jurisdictionColumns'][] = $jurisdictionColumn->getId();
                }
            }
        }
        if (in_array('administrativeArea', $keys)) {
            $attributes['administrativeArea'] = $userGroup->getAdministrativeArea()->getId();
        }
        $expression['data']['attributes'] = $attributes;
        
        return $expression;
    }
}
