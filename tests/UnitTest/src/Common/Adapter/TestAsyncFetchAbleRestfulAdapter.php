<?php
namespace Sdk\Common\Adapter;

class TestAsyncFetchAbleRestfulAdapter
{
    use AsyncFetchAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'member';
    }
}
