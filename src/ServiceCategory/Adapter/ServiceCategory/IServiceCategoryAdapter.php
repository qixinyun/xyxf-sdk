<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IEnableAbleAdapter;

interface IServiceCategoryAdapter extends IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter, IEnableAbleAdapter
{
}
