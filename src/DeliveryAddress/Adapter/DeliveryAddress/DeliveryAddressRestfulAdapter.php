<?php
namespace Sdk\DeliveryAddress\Adapter\DeliveryAddress;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\DeliveryAddress\Model\DeliveryAddress;
use Sdk\DeliveryAddress\Model\NullDeliveryAddress;
use Sdk\DeliveryAddress\Translator\DeliveryAddressRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ModifyStatusAbleRestfulAdapterTrait;

class DeliveryAddressRestfulAdapter extends GuzzleAdapter implements IDeliveryAddressAdapter
{
    use FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        ModifyStatusAbleRestfulAdapterTrait,
        CommonMapErrorsTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
            'DELIVERY_ADDRESS_LIST'=>[
                'fields'=>[
                    'deliveryAddresss'=>'area,address,postalCode,realName,cellphone,isDefaultAddress'
                ],
                'include'=> 'member'
            ],
            'DELIVERY_ADDRESS_FETCH_ONE'=>[
                'fields'=>[],
                'include'=> 'member'
            ]
        ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new DeliveryAddressRestfulTranslator();
        $this->resource = 'deliveryAddress';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        $commonMapErrors = $this->commonMapErrors();

        return $$commonMapErrors;
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullDeliveryAddress::getInstance());
    }

    protected function addAction(DeliveryAddress $deliveryAddress) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $deliveryAddress,
            array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress',
                'member'
            )
        );

        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($deliveryAddress);
            return true;
        }

        return false;
    }

    protected function editAction(DeliveryAddress $deliveryAddress) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $deliveryAddress,
            array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress'
            )
        );

        $this->patch(
            $this->getResource().'/'.$deliveryAddress->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($deliveryAddress);
            return true;
        }

        return false;
    }

    public function setDefault(DeliveryAddress $deliveryAddress) : bool
    {
        $this->patch(
            $this->getResource().'/'.$deliveryAddress->getId().'/setDefault'
        );

        if ($this->isSuccess()) {
            $this->translateToObject($deliveryAddress);
            return true;
        }
        return false;
    }
}
