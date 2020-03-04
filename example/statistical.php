<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

// statistical 测试
// $statistical = new Sdk\statistical\Model\statistical();
$statisticalRepository = new Sdk\Statistical\Repository\StatisticalRepository(new Sdk\Statistical\Adapter\StaticsServiceCountAdapter());

// $filter['enterpriseIds'] = 1;
// $filter['memberId'] = 1;
$filter['enterpriseId'] = 1;

$statistical = $statisticalRepository->analyse($filter);
print_r($statistical);die;