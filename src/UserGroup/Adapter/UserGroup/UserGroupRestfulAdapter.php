<?php
namespace Sdk\UserGroup\Adapter\UserGroup;

use Marmot\Framework\Adapter\Restful\GuzzleAdapter;
// use Marmot\Classes\Translator;
// use Marmot\Adapter\Restful\Strategy\EtagCacheStrategy;
use Marmot\Interfaces\INull;
use Marmot\Interfaces\IRestfulTranslator;

use Marmot\Core;

use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use UserGroup\Model\UserGroup;
use UserGroup\Model\NullUserGroup;
use Sdk\UserGroup\Translator\UserGroupRestfulTranslator;

class UserGroupRestfulAdapter extends GuzzleAdapter implements IUserGroupAdapter
{
    // use AsyncFetchAbleRestfulAdapterTrait, FetchAbleRestfulAdapterTrait, EtagCacheStrategy;
    use AsyncFetchAbleRestfulAdapterTrait, FetchAbleRestfulAdapterTrait;

    private $translator;
    private $resource;

    const SCENARIOS = [
        'USERGROUP_LIST'=>[
            'fields'=>['userGroups'=>'id,name,shortName,jurisdictionColumns,updateTime,status']
        ],
        'USERGROUP_CACHE' =>[
            'fields'=>['userGroups'=>'id,name,shortName']
        ],
        'USERGROUP_FETCH_ONE'=>[
            'fields'=>[]
        ]
    ];
    
    public function __construct()
    {
        parent::__construct(
            Core::$container->get('services.backend.url')
        );
        $this->translator = new UserGroupRestfulTranslator();
        $this->scenario = array();
        $this->resource = 'userGroups';
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, new NullUserGroup());
    }

    protected function fetchOneAction(int $id, INull $null)
    {

        $this->getWithCache(
            $this->getResource().'/'.$id
        );

        return $this->isSuccess() ? $this->translateToObject() : $null;
    }

    protected function searchAction(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array {

        $this->getWithCache(
            $this->getResource(),
            array(
                'filter'=>$filter,
                'sort'=>implode(',', $sort),
                'page'=>array('size'=>$size, 'number'=>$number)
            )
        );

        return $this->isSuccess() ? $this->translateToObjects() : array(0, array());
    }

    public function add(UserGroup $userGroup) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $userGroup,
            array('name', 'shortName', 'jurisdictionColumns')
        );
        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($userGroup);
            return true;
        }

        return false;
    }

    public function edit(UserGroup $userGroup) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $userGroup,
            array('name', 'shortName', 'jurisdictionColumns')
        );

        $this->patch(
            $this->getResource().'/'.$userGroup->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($userGroup);
            return true;
        }

        return false;
    }
}
