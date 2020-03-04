<?php
namespace Sdk\ServiceRequirement\Adapter\ServiceRequirement;

use Marmot\Interfaces\IAsyncAdapter;
use Sdk\Common\Adapter\IFetchAbleAdapter;

interface IServiceRequirementAdapter extends IAsyncAdapter, IFetchAbleAdapter, IServiceRequirementOperatAdapter
{
}
