<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

// serviceCategory 测试
$parentCategory = new Sdk\ServiceCategory\Model\ParentCategory();
$serviceCategory = new Sdk\ServiceCategory\Model\ServiceCategory();
$parentCategoryObject = new Sdk\ServiceCategory\Repository\ParentCategoryRepository();
$serviceCategoryObject = new Sdk\ServiceCategory\Repository\ServiceCategoryRepository();

$parent = $parentCategoryObject->fetchOne(10);

$parentCategory->setId(10);
$parentCategory->setName('嘻嘻嘻');

// var_dump($parentCategory->add());
// var_dump($parentCategory->edit());
// var_dump($parentCategoryObject->fetchOne(1));
// var_dump($parentCategoryObject->fetchList(array(1, 2, 3)));

$serviceCategory->setId(64);
$serviceCategory->setName('weekss');
$serviceCategory->setParentCategory($parent);
$serviceCategory->setQualificationName('');
$serviceCategory->setCommission(1.1);
$serviceCategory->setIsQualification(0);
$serviceCategory->setStatus(0);

// var_dump($serviceCategory->add());
// var_dump($serviceCategory->edit());
// var_dump($serviceCategory->enable());
// var_dump($serviceCategory->disable());
var_dump($serviceCategoryObject->fetchOne(1));
var_dump($serviceCategoryObject->fetchList(array(1, 2, 3)));