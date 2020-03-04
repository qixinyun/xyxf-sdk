<?php
namespace Sdk\DispatchDepartment\Adapter\DispatchDepartment;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\DispatchDepartment\Model\DispatchDepartment;
use Sdk\DispatchDepartment\Model\NullDispatchDepartment;
use Sdk\DispatchDepartment\Translator\DispatchDepartmentRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\EnableAbleRestfulAdapterTrait;

class DispatchDepartmentRestfulAdapter extends GuzzleAdapter implements IDispatchDepartmentAdapter
{
    use FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        EnableAbleRestfulAdapterTrait,
        CommonMapErrorsTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
            'DISPATCHDEPARTMENT_LIST'=>[
                'fields'=>[
                    'dispatchDepartments'=>'name,remark,status,createTime,updateTime'
                ],
                'include'=> 'crew'
            ],
            'DISPATCHDEPARTMENT_FETCH_ONE'=>[
                'fields'=>[],
                'include'=> 'crew'
            ]
        ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new DispatchDepartmentRestfulTranslator();
        $this->resource = 'dispatchDepartments';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        $mapErrors = [
            100 => DISPATCH_DEPARTMENT_NAME_EXIST
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
        return $this->fetchOneAction($id, NullDispatchDepartment::getInstance());
    }

    protected function addAction(DispatchDepartment $dispatchDepartment) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $dispatchDepartment,
            array(
                'name',
                'remark',
                'status',
                'crew'
            )
        );
        
        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($dispatchDepartment);
            return true;
        }

        return false;
    }
        

    protected function editAction(DispatchDepartment $dispatchDepartment) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $dispatchDepartment,
            array(
                'name',
                'remark',
                'status'
            )
        );

        $this->patch(
            $this->getResource().'/'.$dispatchDepartment->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($dispatchDepartment);
            return true;
        }

        return false;
    }
}
