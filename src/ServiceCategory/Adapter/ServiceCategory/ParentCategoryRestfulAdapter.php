<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\ServiceCategory\Model\ParentCategory;
use Sdk\ServiceCategory\Model\NullParentCategory;
use Sdk\ServiceCategory\Translator\ParentCategoryRestfulTranslator;

class ParentCategoryRestfulAdapter extends GuzzleAdapter implements IParentCategoryAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'PARENTCATEGORY_LIST'=>[
            'fields'=>[
                'parentCategories'=>'name,createTime,updateTime'
            ]
        ],
        'PARENTCATEGORY_FETCH_ONE'=>[
            'fields'=>[]
        ]
    ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new ParentCategoryRestfulTranslator();
        $this->resource = 'parentCategories';
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
        return $this->fetchOneAction($id, NullParentCategory::getInstance());
    }
    /**
     * [addAction 认证父级分类信息]
     * @param ParentCategory $parentCategory [父级分类对象]
     * @return [bool]                [返回类型]
     */
    protected function addAction(ParentCategory $parentCategory) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $parentCategory,
            array(
                'name'
            )
        );
        
        $this->post(
            $this->getResource(),
            $data
        );
        
        if ($this->isSuccess()) {
            $this->translateToObject($parentCategory);
            return true;
        }

        return false;
    }
    /**
     * [editAction 编辑父级分类信息]
     * @param  ParentCategory $parentCategory [父级分类对象]
     * @return [bool]                 [返回类型]
     */
    protected function editAction(ParentCategory $parentCategory) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $parentCategory,
            array(
                'name'
            )
        );
        
        $this->patch(
            $this->getResource().'/'.$parentCategory->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($parentCategory);
            return true;
        }

        return false;
    }
}
