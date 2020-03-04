<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();


//member 测试
$member = new Sdk\Member\Model\Member;

//$member->setId('2');
$member->setCellphone('13201816773');
//$member->setOldPassword('123456weeks');
$member->setPassword('password123');
//$member->setNickName('weekss');
//$member->setBirthday('2019-10-31');

//var_dump($member->signUp()); //done
var_dump($member->signIn()); //done 
//var_dump($member->resetPassword()); //done
//var_dump($member->updateCellphone()); //done
//var_dump($member->updatePassword()); //done
//var_dump($member->edit()); //done

// naturalPerson 测试
//$naturalPerson = new Sdk\NaturalPerson\Model\NaturalPerson;

//$naturalPerson->setId('1');
//$naturalPerson->setRejectReason('身份证错误');
// $naturalPerson->setRealName('weeksssss');
// $naturalPerson->setIdentityInfo(new Sdk\NaturalPerson\Model\IdentityInfo(
// 	'61052719980821009X',
// 	array('name' => 'name', 'identify' => '1.jpg'),
// 	array('name' => 'name', 'identify' => '2.jpg'),
// 	array('name' => 'name', 'identify' => '3.jpg')
// ));

//var_dump($naturalPerson->add()); //done
//var_dump($naturalPerson->edit()); //done
//var_dump($naturalPerson->reject()); //done
//var_dump($naturalPerson->approve()); //done

// crew 测试

// $crew = new Sdk\Crew\Model\Crew;

// $crew->setId('1');
// $crew->setStatus('-2');
//$crew->setCellphone('18800000000');
//$crew->setOldPassword('panda521');
//$crew->setPassword('PXpassword0000');

//var_dump($crew->updatePassword()); //done
//var_dump($crew->signIn()); //done
//var_dump($crew->disable()); //done
//var_dump($crew->enable()); //done
