<?php
namespace Sdk\Service\Adapter\Service;

use Marmot\Framework\Adapter\Restful\GuzzleAdapter;
use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Adapter\ApplyAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ResubmitAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ModifyStatusAbleRestfulAdapterTrait;

use Sdk\Service\Model\NullService;
use Sdk\Service\Model\Service;

use Sdk\Service\Translator\ServiceRestfulTranslator;

class ServiceRestfulAdapter extends GuzzleAdapter implements IServiceAdapter
{
    use CommonMapErrorsTrait,
        ApplyAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait,
        FetchAbleRestfulAdapterTrait,
        ResubmitAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        ModifyStatusAbleRestfulAdapterTrait;

    const SCENARIOS = [
        'OA_SERVICE_LIST' => [
            'fields' => [
                'services'=>'number,title,cover,serviceCategory,enterprise,applyStatus,updateTime'
            ],
            'include' => 'enterprise,snapshots,serviceCategory',
        ],
        'PORTAL_SERVICE_LIST' => [
            'fields' => [],
            'include' => 'enterprise,snapshots,serviceCategory',
        ],
        'SERVICE_FETCH_ONE' => [
            'fields' => [],
            'include' => 'enterprise,snapshots,serviceCategory',
        ],
    ];

    private $translator;

    private $resource;

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new ServiceRestfulTranslator();
        $this->resource = 'services';
        $this->scenario = array();
    }

    protected function getMapErrors(): array
    {
        return $this->commonMapErrors();
    }

    protected function getTranslator(): IRestfulTranslator
    {
        return $this->translator;
    }

    protected function getResource(): string
    {
        return $this->resource;
    }

    public function scenario($scenario): void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullService::getInstance());
    }
    /**
     * [addAction 发布服务]
     * @param Service $service [object]
     * @return [type]           [bool]
     */
    protected function addAction(Service $service): bool
    {
        $data = $this->getTranslator()->objectToArray(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
                'enterprise',
            )
        );
        
        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($service);
            return true;
        }

        return false;
    }
    /**
     * [editAction 编辑]
     * @param  Service $service [object]
     * @return [type]           [bool]
     */
    protected function editAction(Service $service): bool
    {
        $data = $this->getTranslator()->objectToArray(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
            )
        );

        $this->patch(
            $this->getResource() . '/' . $service->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($service);
            return true;
        }

        return false;
    }
    /**
     * [resubmitAction 重新认证]
     * @param  Service $service [object]
     * @return [type]           [bool]
     */
    protected function resubmitAction(Service $service): bool
    {
        $data = $this->getTranslator()->objectToArray(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
            )
        );

        $this->patch(
            $this->getResource() . '/' . $service->getId() . '/resubmit',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($service);
            return true;
        }

        return false;
    }
    /**
     * [onShelf 上架服务]
     * @param  Service $service [object]
     * @return [type]           [bool]
     */
    public function onShelf(Service $service): bool
    {
        return $this->onShelfAction($service);
    }

    protected function onShelfAction(Service $service): bool
    {
        $this->patch(
            $this->getResource() . '/' . $service->getId() . '/onShelf'
        );
        if ($this->isSuccess()) {
            $this->translateToObject($service);
            return true;
        }
        return false;
    }
    /**
     * [offStock 下架服务]
     * @param  Service $service [object]
     * @return [type]           [bool]
     */
    public function offStock(Service $service): bool
    {
        return $this->offStockAction($service);
    }

    protected function offStockAction(Service $service): bool
    {
        $this->patch(
            $this->getResource() . '/' . $service->getId() . '/offStock'
        );

        if ($this->isSuccess()) {
            $this->translateToObject($service);
            return true;
        }
        return false;
    }
}
