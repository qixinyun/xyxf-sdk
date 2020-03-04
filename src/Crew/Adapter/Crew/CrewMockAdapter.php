<?php
namespace Sdk\Crew\Adapter\Crew;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\EnableAbleMockAdapterTrait;

use Sdk\Crew\Model\Crew;
use Sdk\Crew\Utils\MockFactory;

class CrewMockAdapter implements ICrewAdapter
{
    use OperatAbleMockAdapterTrait, EnableAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateCrewObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $crewList = array();

        foreach ($ids as $id) {
            $crewList[] = MockFactory::generateCrewObject($id);
        }

        return $crewList;
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);
        return array($this->fetchList($ids), $count);
    }

    public function signIn(Crew $crew) : bool
    {
        unset($crew);
        return true;
    }

    public function updatePassword(Crew $crew) : bool
    {
        unset($crew);
        return true;
    }

    public function fetchOneAsync(int $id)
    {
        return MockFactory::generateCrewObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateCrewObject($id);
        }

        return $parentCategoryList;
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);
        return array($this->fetchList($ids), $count);
    }
}
