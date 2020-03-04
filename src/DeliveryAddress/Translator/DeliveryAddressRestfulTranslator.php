<?php
namespace Sdk\DeliveryAddress\Translator;

use Sdk\DeliveryAddress\Model\DeliveryAddress;
use Sdk\DeliveryAddress\Model\NullDeliveryAddress;
use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\Member\Translator\MemberRestfulTranslator;

use Marmot\Interfaces\IRestfulTranslator;

class DeliveryAddressRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getMemberRestfulTranslator()
    {
        return new MemberRestfulTranslator();
    }

    public function arrayToObject(array $expression, $deliveryAddress = null)
    {
        return $this->translateToObject($expression, $deliveryAddress);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $deliveryAddress = null)
    {
        if (empty($expression)) {
            return NullDeliveryAddress::getInstance();
        }

        if ($deliveryAddress == null) {
            $deliveryAddress = new DeliveryAddress();
        }
        
        $data =  $expression['data'];

        $id = $data['id'];

        $deliveryAddress->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['area'])) {
            $deliveryAddress->setArea($attributes['area']);
        }
        if (isset($attributes['address'])) {
            $deliveryAddress->setAddress($attributes['address']);
        }
        if (isset($attributes['postalCode'])) {
            $deliveryAddress->setPostalCode($attributes['postalCode']);
        }
        if (isset($attributes['realName'])) {
            $deliveryAddress->setRealName($attributes['realName']);
        }
        if (isset($attributes['cellphone'])) {
            $deliveryAddress->setCellphone($attributes['cellphone']);
        }
        if (isset($attributes['isDefaultAddress'])) {
            $deliveryAddress->setIsDefaultAddress($attributes['isDefaultAddress']);
        }
        if (isset($attributes['createTime'])) {
            $deliveryAddress->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $deliveryAddress->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $deliveryAddress->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $deliveryAddress->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['member']['data'])) {
            $member = $this->changeArrayFormat($relationships['member']['data']);
            $deliveryAddress->setMember($this->getMemberRestfulTranslator()->arrayToObject($member));
        }

        return $deliveryAddress;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($deliveryAddress, array $keys = array())
    {
        $expression = array();

        if (!$deliveryAddress instanceof DeliveryAddress) {
            return $expression;
        }

        if (empty($keys)) {
            $keys = array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress',
                'member'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'deliveryAddress'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $deliveryAddress->getId();
        }

        $attributes = array();

        if (in_array('area', $keys)) {
            $attributes['area'] = $deliveryAddress->getArea();
        }
        if (in_array('address', $keys)) {
            $attributes['address'] = $deliveryAddress->getAddress();
        }
        if (in_array('postalCode', $keys)) {
            $attributes['postalCode'] = $deliveryAddress->getPostalCode();
        }
        if (in_array('realName', $keys)) {
            $attributes['realName'] = $deliveryAddress->getRealName();
        }
        if (in_array('cellphone', $keys)) {
            $attributes['cellphone'] = $deliveryAddress->getCellphone();
        }
        if (in_array('isDefaultAddress', $keys)) {
            $attributes['isDefaultAddress'] = $deliveryAddress->getIsDefaultAddress();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('member', $keys)) {
            $expression['data']['relationships']['member']['data'] = array(
                array(
                    'type' => 'members',
                    'id' => $deliveryAddress->getMember()->getId()
                )
             );
        }

        return $expression;
    }
}
