<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

// Servicerequirement 测试
$Servicerequirement = new Sdk\ServiceRequirement\Model\ServiceRequirement();
$ServicerequirementRepository = new Sdk\ServiceRequirement\Repository\ServiceRequirementRepository();
$memberRepository = new Sdk\Member\Repository\MemberRepository();
$serviceCategoryRepository = new Sdk\ServiceCategory\Repository\ServiceCategoryRepository();

$Servicerequirement = $ServicerequirementRepository->scenario($ServicerequirementRepository::OA_LIST_MODEL_UN)->fetchOne(2);

var_dump($Servicerequirement);die;
// $Servicerequirement->setTitle('HHHHHHHHH');
// $Servicerequirement->setDetail(array(array("type"=>"text", "value"=>"文本内容")));
// $Servicerequirement->setMinPrice('100.99');
// $Servicerequirement->setMaxPrice('100.99');
// $Servicerequirement->setValidityStartTime(time());
// $Servicerequirement->setValidityEndTime(time());
// $Servicerequirement->setContactName('weeks');
// $Servicerequirement->setContactPhone('13201816774');
// $Servicerequirement->setMember($memberRepository->fetchOne(1));
// $Servicerequirement->setServiceCategory($serviceCategoryRepository->fetchOne(1));


// $Servicerequirement->setId(10);
// $Servicerequirement->setApplyStatus(-2);
// $Servicerequirement->setStatus(-4);
// $Servicerequirement->setRejectReason('错误1312312');

// var_dump($Servicerequirement->add()); //done
// var_dump($Servicerequirement->revoke()); //done
// var_dump($Servicerequirement->close()); //done
// var_dump($Servicerequirement->deletes()); //done
// var_dump($Servicerequirement->approve()); //done
// var_dump($Servicerequirement->reject()); //done
// var_dump($ServicerequirementRepository->fetchOne(1)); //done
// var_dump($ServicerequirementRepository->fetchList(array(2,3,4))); //done
