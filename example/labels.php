<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();
$crew = new Sdk\Crew\Model\Crew($id = 1);

// labels 测试
// $labels = new Sdk\Label\Model\Label;
//$labelsRepository = new Sdk\Labels\Repository\LabelsRepository();


// $labels->setId('19');
// $labels->setName('嘻嘻嘻');
// $labels->setIcon(array('name'=>'图片名称', 'identify'=>'4.jpg'));
// $labels->setCategory(2);
// $labels->setRemark('weeks');
// $labels->setCrew($crew);

// var_dump($labels->add()); //done
// var_dump($labels->edit()); //done
// var_dump($labelsRepository->fetchOne(1)); //done
// var_dump($labelsRepository->fetchList(array(1, 2, 3))); //done


// DispatchDepartment 测试
$DispatchDepartment = new Sdk\DispatchDepartment\Model\DispatchDepartment();
// $DispatchDepartmentRepository = new Sdk\DispatchDepartment\Repository\DispatchDepartmentRepository();

$DispatchDepartment->setId(1);
// $DispatchDepartment->setStatus('-2');
// $DispatchDepartment->setName('谢谢a');
// $DispatchDepartment->setRemark('weeks');
// $DispatchDepartment->setCrew($crew);

// var_dump($DispatchDepartment->add()); //done
// var_dump($DispatchDepartment->edit()); //done
var_dump($DispatchDepartment->disable()); //done
// var_dump($DispatchDepartment->enable()); //done
// var_dump($DispatchDepartmentRepository->fetchOne(1)); //done
// var_dump($DispatchDepartmentRepository->fetchList(array(1, 2, 3))); //done