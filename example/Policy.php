<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();
$crew = new Sdk\Crew\Model\Crew($id = 1);

// policy 测试
$policy = new Sdk\Policy\Model\Policy($id = 1);
$labels = new Sdk\Label\Model\Label(1);
$dispatchDepartment = new Sdk\DispatchDepartment\Model\DispatchDepartment(1);

$policyRepository = new Sdk\Policy\Repository\PolicyRepository();
$dispatchDepartmentRepository = new Sdk\DispatchDepartment\Repository\DispatchDepartmentRepository();
$labelsRepository = new Sdk\Label\Repository\LabelRepository();

// $policy->setId(2);
// $policy->setStatus('-2');
// $policy->setTitle('政策标题dsadsadsa');
// $policy->addApplicableObjects(array(1,2));
// $policy->addDispatchDepartments($dispatchDepartmentRepository->fetchList(array(1, 2, 3, 4)));
// $policy->addApplicableIndustries(array(1,2));
// $policy->setLevel(2);
// $policy->addClassifies(array(1,2));
// $policy->setDetail(array(array("type"=>"text", "value"=>"sss")));
// $policy->setDescription('政策描述---description--政策描述---description政策描述---description');
// $policy->setImage(array("neme"=>"封面图","identify"=>'ewqqweqw.jpg'));
// $policy->setAttachments(array(array("name"=>"政策附件","identify"=>"identify.zip")));
// $policy->addLabels($labelsRepository->fetchList(array(1, 2, 3)));
// $policy->setAdmissibleAddress(array(
// 					array("address"=>"地址","longitude"=>"12.4","latitude"=>"12.4"),
// 					array("address"=>"地址","longitude"=>"12.4","latitude"=>"12.4"),
// 					array("address"=>"地址","longitude"=>"12.4","latitude"=>"12.4")
// 				));
// $policy->setProcessingFlow(array(array("type"=>"text", "value"=>"办理流程")));
// $policy->setCrew($crew);

// var_dump($policy->add());//done
// var_dump($policy->edit());//done
// var_dump($policy->offStock());//done
// var_dump($policy->onShelf());//done
// var_dump($policyRepository->fetchOne(1));//done
// var_dump($policyRepository->fetchList(array(1,2)));//done


// PolicyInterpretation 测试
$policyInterpretation = new Sdk\PolicyInterpretation\Model\PolicyInterpretation();
$policyInterpretationRepository = new Sdk\PolicyInterpretation\Repository\PolicyInterpretationRepository();

$policyInterpretation->setId(1);
$policyInterpretation->setStatus('-2');
$policyInterpretation->setPolicy($policy);
$policyInterpretation->setCover(array("neme"=>"封面图","identify"=>"ewqqweqw.jpg"));
$policyInterpretation->setTitle('政策解读标题dasdadasd');
$policyInterpretation->setDetail(array(array("type"=>"text", "value"=>"文本内容")));
$policyInterpretation->setDescription('政策描述---description--政策描述---description政策描述---description');
$policyInterpretation->setAttachments(array(array("name"=>"政策附件","identify"=>"identify.zip")));
$policyInterpretation->setCrew($crew);

// var_dump($policyInterpretation->add());//done
// var_dump($policyInterpretation->edit());//done
// var_dump($policyInterpretation->offStock());//done
// var_dump($policyInterpretation->onShelf());//done
// var_dump($policyInterpretationRepository->fetchOne(1));//done
// var_dump($policyInterpretationRepository->fetchList(array(1,2,3)));//done