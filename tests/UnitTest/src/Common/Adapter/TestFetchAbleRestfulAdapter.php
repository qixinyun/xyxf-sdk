<?php
namespace Sdk\Common\Adapter;

class TestFetchAbleRestfulAdapter
{
    use FetchAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'member';
    }
}
