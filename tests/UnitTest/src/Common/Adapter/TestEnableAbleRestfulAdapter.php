<?php
namespace Sdk\Common\Adapter;

class TestEnableAbleRestfulAdapter
{
    use EnableAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'member';
    }
}
