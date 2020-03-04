<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();
$Member = new Sdk\Member\Model\Member($id = 1);

// DeliveryAddresss 测试
$DeliveryAddress = new Sdk\DeliveryAddress\Model\DeliveryAddress;
$DeliveryAddressRepository = new Sdk\DeliveryAddress\Repository\DeliveryAddressRepository();

// $DeliveryAddress->setId(1);
// $DeliveryAddress->setArea('陕西省，西安市，雁塔区');
// $DeliveryAddress->setAddress('嘻嘻嘻');
// $DeliveryAddress->setPostalCode(715600);
// $DeliveryAddress->setRealName('weeks');
// $DeliveryAddress->setCellphone('13202938747');
// $DeliveryAddress->setIsDefaultAddress(2);
// $DeliveryAddress->setMember($Member);
// $DeliveryAddress->setStatus(0);

// var_dump($DeliveryAddress->add()); //done
// var_dump($DeliveryAddress->edit()); //done
// var_dump($DeliveryAddress->setDefault()); //done
// var_dump($DeliveryAddress->deletes()); //done
// var_dump($DeliveryAddressRepository->fetchOne(1)); //done
// var_dump($DeliveryAddressRepository->fetchList(array(1, 2, 3))); //done