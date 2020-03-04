<?php
namespace Sdk\Crew\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\EnableAbleRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\Crew\Adapter\Crew\ICrewAdapter;
use Sdk\Crew\Adapter\Crew\CrewMockAdapter;
use Sdk\Crew\Adapter\Crew\CrewRestfulAdapter;
use Sdk\Crew\Model\Crew;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class CrewRepository extends Repository implements ICrewAdapter
{
    use FetchRepositoryTrait,
        AsyncRepositoryTrait,
        EnableAbleRepositoryTrait,
        OperatAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'CREW_LIST';
    const FETCH_ONE_MODEL_UN = 'CREW_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new CrewRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : ICrewAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : ICrewAdapter
    {
        return new CrewMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }

    public function signIn(Crew $crew) : bool
    {
        return $this->getAdapter()->signIn($crew);
    }

    public function updatePassword(Crew $crew) : bool
    {
        return $this->getAdapter()->updatePassword($crew);
    }
}
