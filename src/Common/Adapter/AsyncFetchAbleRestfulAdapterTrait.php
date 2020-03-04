<?php
namespace Sdk\Common\Adapter;

trait AsyncFetchAbleRestfulAdapterTrait
{
    abstract protected function getResource() : string;

    public function fetchOneAsync(int $id)
    {
        return $this->fetchOneAsyncAction($id);
    }

    protected function fetchOneAsyncAction(int $id)
    {
        return $this->getAsync(
            $this->getResource().'/'.$id
        );
    }

    public function fetchListAsync(array $ids)
    {
        return $this->fetchListAsyncAction($ids);
    }

    protected function fetchListAsyncAction(array $ids)
    {
        return $this->getAsync(
            $this->getResource().'/'.implode(',', $ids)
        );
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) {
        return $this->searchAsyncAction($filter, $sort, $number, $size);
    }

    protected function searchAsyncAction(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) {
        return $this->getAsync(
            $this->getResource(),
            array(
                'filter'=>$filter,
                'sort'=>implode(',', $sort),
                'page'=>array('size'=>$size, 'number'=>$number)
            )
        );
    }
}
