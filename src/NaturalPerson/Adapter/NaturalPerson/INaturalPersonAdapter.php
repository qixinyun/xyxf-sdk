<?php
namespace Sdk\NaturalPerson\Adapter\NaturalPerson;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;

interface INaturalPersonAdapter extends IFetchAbleAdapter, IApplyAbleAdapter, IOperatAbleAdapter, IAsyncAdapter
{
}
