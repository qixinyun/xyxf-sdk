<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;

interface IParentCategoryAdapter extends IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter
{
}
