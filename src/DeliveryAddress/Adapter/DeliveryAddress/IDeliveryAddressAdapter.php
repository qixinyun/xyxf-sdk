<?php
namespace Sdk\DeliveryAddress\Adapter\DeliveryAddress;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IModifyStatusAbleAdapter;

interface IDeliveryAddressAdapter extends IFetchAbleAdapter, IOperatAbleAdapter, IModifyStatusAbleAdapter
{
}
