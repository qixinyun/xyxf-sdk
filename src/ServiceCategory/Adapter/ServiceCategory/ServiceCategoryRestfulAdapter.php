<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\EnableAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Model\NullServiceCategory;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

class ServiceCategoryRestfulAdapter extends GuzzleAdapter implements IServiceCategoryAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        EnableAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    const SCENARIOS = [
        'SERVICECATEGORY_LIST'=>[
            'fields'=>[
                'serviceCategories'=>'name,commission,parentCategory,isQualification,status,createTime,updateTime'
            ],
            'include'=>'parentCategory'
        ],
        'SERVICECATEGORY_FETCH_ONE'=>[
            'fields'=>[],
            'include'=>'parentCategory'
        ]
    ];

    private $translator;

    private $resource;

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new ServiceCategoryRestfulTranslator();
        $this->resource = 'serviceCategories';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        $mapErrors = [
            100 => CATEGORY_IS_EXIST
        ];
        $commonMapErrors = $this->commonMapErrors();

        return $mapErrors+$commonMapErrors;
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
        return $this->fetchOneAction($id, NullServiceCategory::getInstance());
    }

    protected function addAction(ServiceCategory $serviceCategory) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $serviceCategory,
            array(
                'name',
                'parentCategory',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            )
        );

        $this->post(
            $this->getResource(),
            $data
        );
        
        if ($this->isSuccess()) {
            $this->translateToObject($serviceCategory);
            return true;
        }

        return false;
    }

    protected function editAction(ServiceCategory $serviceCategory) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $serviceCategory,
            array(
                'name',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            )
        );
        
        $this->patch(
            $this->getResource().'/'.$serviceCategory->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($serviceCategory);
            return true;
        }

        return false;
    }
}
