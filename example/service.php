<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

// service 测试
$service = new Sdk\service\Model\service();
$serviceRepository = new Sdk\service\Repository\serviceRepository();
$enterpriseRepository = new Sdk\Enterprise\Repository\EnterpriseRepository();
$serviceCategoryRepository = new Sdk\ServiceCategory\Repository\ServiceCategoryRepository();

$service = $serviceRepository->fetchOne(1);
print_r($service);
// $service->setId(14);
// $service->setStatus(-4);
// $service->setTitle('ISO9001:hhhhhh');
// $service->setDetail(array(array("type"=>"text", "value"=>"绿盾征信立信认证是对企业整体信用状况的客观展现。在政府采购、招标投标、行政审批、市场准入、资质审核、商务合作、金融信贷等领域，依法出具、使用绿盾征信信用报告是立信认证普遍常见、通行的表现方式，已成为企业在市场经济活动中获得成功的关键节点。
// 在时下大力推行社会诚信体系建设的背景下，拥有一份系统完善的征信报告会在企业形象、企业竞争力、企业文化、企业管理、企业融资等众多方面为企业提供有力的支持。
// 通过建立征信档案，保障企业的各项诚信数据能够在较早时间得到采集、整理和保存。在企业竞标、商务谈判、洽谈合作、融资贷款、产品发布、人才招聘等众多领域需要出具诚信的证明时得到有力的文件证明支持。")));
// $service->setPrice(array(
//                 array("name"=>"天", "value"=>"1"),
//                 array("name"=>"月", "value"=>"30"),
//                 array("name"=>"年", "value"=>"300"),
//             ));
// $service->setCover(array("name"=>"维修洗衣机服务", "identify"=>"3.jpg"));
// $service->setContract(array("name"=>"维修洗衣机服务合同", "identify"=>"3.pdf"));
// $service->setServiceObjects(array(1,3));
// $service->setRejectReason('错误sdadasdas');
// $service->setEnterprise($enterpriseRepository->fetchOne(1));
// $service->setServiceCategory($serviceCategoryRepository->fetchOne(38));

// var_dump($service->add()); //done
// var_dump($service->edit()); //done
// var_dump($service->resubmit()); //done
// var_dump($service->revoke()); //done
// var_dump($service->close()); //done
// var_dump($service->deletes()); //done
// var_dump($service->approve()); //done
// var_dump($service->reject()); //done
// var_dump($service->onShelf()); //done
// var_dump($service->offStock()); //done
// var_dump($serviceRepository->fetchOne(1)); //done
// var_dump($serviceRepository->fetchList(array(2,3,4))); //done
