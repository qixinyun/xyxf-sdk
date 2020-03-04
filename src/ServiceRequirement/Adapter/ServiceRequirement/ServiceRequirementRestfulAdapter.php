<?php
namespace Sdk\ServiceRequirement\Adapter\ServiceRequirement;

use Marmot\Framework\Adapter\Restful\GuzzleAdapter;
use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Adapter\ApplyAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\ModifyStatusAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;

use Sdk\ServiceRequirement\Model\NullServiceRequirement;
use Sdk\ServiceRequirement\Model\ServiceRequirement;

use Sdk\ServiceRequirement\Translator\ServiceRequirementRestfulTranslator;

class ServiceRequirementRestfulAdapter extends GuzzleAdapter implements IServiceRequirementAdapter
{
    use ApplyAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait,
        CommonMapErrorsTrait,
        ModifyStatusAbleRestfulAdapterTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait;

    const SCENARIOS = [
        'OA_SERVICE_REQUIREMENT_LIST' => [
            'fields' => [
                'serviceRequirements'=>
                'number,title,detail,serviceCategory,contactName,contactPhone,applyStatus,updateTime'
            ],
            'include' => 'member,serviceCategory',
        ],
        'PORTAL_SERVICE_REQUIREMENT_LIST' => [
            'fields' => [],
            'include' => 'member,serviceCategory',
        ],
        'SERVICE_REQUIREMENT_FETCH_ONE' => [
            'fields' => [],
            'include' => 'member,serviceCategory',
        ],
    ];

    private $translator;

    private $resource;

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct($uri, $authKey);
        $this->translator = new ServiceRequirementRestfulTranslator();
        $this->resource = 'serviceRequirements';
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
        return $this->fetchOneAction($id, NullServiceRequirement::getInstance());
    }

    protected function addAction(ServiceRequirement $serviceRequirement): bool
    {
        $data = $this->getTranslator()->objectToArray(
            $serviceRequirement,
            array(
                'serviceCategory',
                'title',
                'detail',
                'minPrice',
                'maxPrice',
                'validityStartTime',
                'validityEndTime',
                'contactName',
                'contactPhone',
                'member'
            )
        );

        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($serviceRequirement);
            return true;
        }

        return false;
    }

    protected function editAction(ServiceRequirement $serviceRequirement): bool
    {
        unset($serviceRequirement);
        return false;
    }
}
