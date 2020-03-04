<?php
namespace Sdk\Common\Repository;

use Marmot\Interfaces\IAsyncAdapter;

class TestAsyncRepository implements IAsyncAdapter
{
    use AsyncRepositoryTrait;
}
