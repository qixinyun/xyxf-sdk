<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

// authentication 测试
$authentication = new Sdk\Authentication\Model\Authentication();

$enterprise = new Sdk\Enterprise\Model\Enterprise();
$enterpriseRepository = new Sdk\Enterprise\Repository\EnterpriseRepository();
$authenticationRepository = new Sdk\Authentication\Repository\AuthenticationRepository();
$serviceCategoryRepository = new Sdk\ServiceCategory\Repository\ServiceCategoryRepository();

$serviceCategoryId = [1,2,3];
// $serviceCategory = $serviceCategoryRepository->fetchList($serviceCategoryId);

// foreach ($serviceCategoryId as $value) {
// 	$qualification = new Sdk\Authentication\Model\Qualification();
// 	$qualification->setImage(array('name' => '图片', 'identify' => '1.png'));
// 	$qualification->setServiceCategory($serviceCategoryRepository->fetchOne($value));
// 	$authentication->addQualification($qualification);
// }
// $authentication->setId(10);
// $authentication->setEnterprise($enterpriseRepository->fetchOne(1));
// $authentication->setQualificationImage(array('name' => '图片dsasdasd', 'identify' => '2.png'));
// $authentication->setRejectReason('hhhhhhhhh');

// var_dump($authentication->add()); //done
// var_dump($authentication->resubmit()); //done
// var_dump($authentication->approve()); //done
// var_dump($authentication->reject()); //done
$auth = $authenticationRepository->scenario($authenticationRepository::LIST_MODEL_UN)->fetchOne(11);
var_dump($auth); //done
// var_dump($authenticationRepository->fetchList(array(11,12,33,34))); //done