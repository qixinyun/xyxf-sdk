<?php
namespace Sdk\Common\Adapter;

use Marmot\Interfaces\INull;

trait FetchAbleRestfulAdapterTrait
{
    abstract protected function getResource() : string;

    public function fetchOne(int $id, INull $null)
    {
        return $this->fetchOneAction($id, $null);
    }

    protected function fetchOneAction(int $id, INull $null)
    {
        $this->get(
            $this->getResource().'/'.$id
        );

        return $this->isSuccess() ? $this->translateToObject() : $null;
    }

    public function fetchList(array $ids) : array
    {
        return $this->fetchListAction($ids);
    }

    protected function fetchListAction(array $ids) : array
    {
        $this->get(
            $this->getResource().'/'.implode(',', $ids)
        );

        return $this->isSuccess() ? $this->translateToObjects() : array(0, array());
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array {
        return $this->searchAction($filter, $sort, $number, $size);
    }

    protected function searchAction(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array {
        $this->get(
            $this->getResource(),
            array(
                'filter'=>$filter,
                'sort'=>implode(',', $sort),
                'page'=>array('size'=>$size, 'number'=>$number)
            )
        );

        return $this->isSuccess() ? $this->translateToObjects() : array(0, array());
    }
}
