<?php
namespace Sdk\Service\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\Enterprise\Translator\EnterpriseRestfulTranslator;

use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

use Sdk\Service\Model\Service;
use Sdk\Service\Model\NullService;

use Sdk\Policy\Translator\PolicyRestfulTranslatorTrait;

class ServiceRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait, PolicyRestfulTranslatorTrait;

    public function getServiceCategoryRestfulTranslator()
    {
        return new ServiceCategoryRestfulTranslator();
    }

    public function getEnterpriseRestfulTranslator()
    {
        return new EnterpriseRestfulTranslator();
    }

    public function getSnapshotsRestfulTranslator()
    {
        return new SnapshotsRestfulTranslator();
    }

    public function arrayToObject(array $expression, $service = null)
    {
        return $this->translateToObject($expression, $service);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $service = null)
    {
        if (empty($expression)) {
            return NullService::getInstance();
        }

        if ($service == null) {
            $service = new Service();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $service->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['title'])) {
            $service->setTitle($attributes['title']);
        }
        if (isset($attributes['number'])) {
            $service->setNumber($attributes['number']);
        }
        if (isset($attributes['cover'])) {
            $service->setCover($attributes['cover']);
        }
        if (isset($attributes['price'])) {
            $service->setPrice($attributes['price']);
        }
        if (isset($attributes['minPrice'])) {
            $service->setMinPrice($attributes['minPrice']);
        }
        if (isset($attributes['maxPrice'])) {
            $service->setMaxPrice($attributes['maxPrice']);
        }
        if (isset($attributes['contract'])) {
            $service->setContract($attributes['contract']);
        }
        if (isset($attributes['detail'])) {
            $service->setDetail($attributes['detail']);
        }
        if (isset($attributes['serviceObjects'])) {
            $serviceObjects = $this->setUpApplicableObjects($attributes['serviceObjects']);
            $service->setServiceObjects($serviceObjects);
        }
        if (isset($attributes['volume'])) {
            $service->setVolume($attributes['volume']);
        }
        if (isset($attributes['attentionDegree'])) {
            $service->setAttentionDegree($attributes['attentionDegree']);
        }
        if (isset($attributes['rejectReason'])) {
            $service->setRejectReason($attributes['rejectReason']);
        }
        if (isset($attributes['createTime'])) {
            $service->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $service->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $service->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $service->setStatusTime($attributes['statusTime']);
        }
        if (isset($attributes['applyStatus'])) {
            $service->setApplyStatus($attributes['applyStatus']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['serviceCategory']['data'])) {
            $serviceCategory = $this->changeArrayFormat($relationships['serviceCategory']['data']);
            $service->setServiceCategory(
                $this->getServiceCategoryRestfulTranslator()->arrayToObject($serviceCategory)
            );
        }

        // if (isset($relationships['snapshots']['data'])) {
        //     $snapshots = $this->changeArrayFormat($relationships['snapshots']['data']);
        //     $service->addSnapshots(
        //         $this->getSnapshotsRestfulTranslator()->arrayToObject($snapshots)
        //     );
        // }

        if (isset($relationships['enterprise']['data'])) {
            $enterprise = $this->changeArrayFormat($relationships['enterprise']['data']);
            $service->setEnterprise(
                $this->getEnterpriseRestfulTranslator()->arrayToObject($enterprise)
            );
        }

        return $service;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($service, array $keys = array())
    {
        if (!$service instanceof Service) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
                'rejectReason',
                'enterprise',
                'serviceCategory',
            );
        }

        $expression = array(
            'data' => array(
                'type' => 'services'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $service->getId();
        }

        $attributes = array();

        if (in_array('title', $keys)) {
            $attributes['title'] = $service->getTitle();
        }
        if (in_array('cover', $keys)) {
            $attributes['cover'] = $service->getCover();
        }
        if (in_array('price', $keys)) {
            $attributes['price'] = $service->getPrice();
        }
        if (in_array('contract', $keys)) {
            $attributes['contract'] = $service->getContract();
        }
        if (in_array('detail', $keys)) {
            $attributes['detail'] = $service->getDetail();
        }
        if (in_array('serviceObjects', $keys)) {
            $attributes['serviceObjects'] = $service->getServiceObjects();
        }
        if (in_array('rejectReason', $keys)) {
            $attributes['rejectReason'] = $service->getRejectReason();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('enterprise', $keys)) {
            $expression['data']['relationships']['enterprise']['data'] = array(
                array(
                    'type'=>'enterprises',
                    'id'=>$service->getEnterprise()->getId()
                )
            );
        }

        if (in_array('serviceCategory', $keys)) {
            $expression['data']['relationships']['serviceCategory']['data'] = array(
                array(
                    'type'=>'serviceCategories',
                    'id'=>$service->getServiceCategory()->getId()
                )
            );
        }

        return $expression;
    }
}
