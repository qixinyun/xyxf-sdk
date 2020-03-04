<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

/*
 * 进入容器运行测试
 */
// member 测试
$member = new Sdk\Member\Model\Member;

$member->setId(1);
//$member->setStatus(-2);
// $member->setCellphone('15129873653');
// $member->setOldPassword('123456weeks');
// $member->setPassword('password123');
// $member->setNickName('weekss');
// $member->setBirthday('2019-10-31');

// var_dump($member->signUp()); //done
// var_dump($member->signIn()); //done 
// var_dump($member->resetPassword()); //done
// var_dump($member->updateCellphone()); //done
// var_dump($member->updatePassword()); //done
// var_dump($member->edit()); //done
//var_dump($member->disable()); //done
//var_dump($member->enable()); //done
// $memberRepository = new Sdk\Member\Repository\MemberRepository;

// $member = $memberRepository->scenario($memberRepository::FETCH_ONE_MODEL_UN)->fetchOne(1);

// print_r($member);

// naturalPerson 测试
$naturalPerson = new Sdk\NaturalPerson\Model\NaturalPerson;

$naturalPerson->setId(9);
// $naturalPerson->setRejectReason('身份证错误');
// $naturalPerson->setRealName('weeks');
// $naturalPerson->setIdentityInfo(new Sdk\NaturalPerson\Model\IdentityInfo(
// 	'618987272737483726',
// 	array('name' => 'name', 'identify' => '1.jpg'),
// 	array('name' => 'name', 'identify' => '2.jpg'),
// 	array('name' => 'name', 'identify' => '3.jpg')
// ));
// $naturalPerson->setMember(new Sdk\Member\Model\Member(1));

// var_dump($naturalPerson->add()); //done
// var_dump($naturalPerson->edit()); //done
//var_dump($naturalPerson->reject()); //done
// var_dump($naturalPerson->approve()); //done

// crew 测试

 $crew = new Sdk\Crew\Model\Crew;

$crew->setId('1');
// $crew->setStatus('-2');
// $crew->setCellphone('18800000000');
// $crew->setOldPassword('panda521');
// $crew->setPassword('PXpassword0000');

// var_dump($crew->updatePassword()); //done
// var_dump($crew->signIn()); //done
var_dump($crew->disable()); //done
// var_dump($crew->enable()); //done
