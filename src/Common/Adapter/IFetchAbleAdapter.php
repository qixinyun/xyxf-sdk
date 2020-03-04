<?php
namespace Sdk\Common\Adapter;

interface IFetchAbleAdapter
{
    public function fetchOne($id);

    public function fetchList(array $ids) : array;

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array;
}
