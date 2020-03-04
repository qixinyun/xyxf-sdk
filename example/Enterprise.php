<?php
include '../vendor/autoload.php';
require '../Core.php';

$core = Marmot\Core::getInstance();
$core->initCli();

// enterprise 测试
$enterprise = new Sdk\Enterprise\Model\Enterprise();
$enterpriseObject = new Sdk\Enterprise\Repository\EnterpriseRepository();
$unAuditedEnterpriseObject = new Sdk\Enterprise\Repository\unAuditedEnterpriseRepository();

$memberObject = new Sdk\Member\Repository\MemberRepository();
$member = $memberObject->fetchOne(1);

$enterprise->setId(1);
$enterprise->setName('企信云科技sdasd');
$enterprise->setUnifiedSocialCreditCode('1324948736747');
$enterprise->setLogo(array('name' => '企业LOGOname', 'identify' => '企业LOGOidentify.jpg'));
$enterprise->setBusinessLicense(array('name' => '营业执照name', 'identify' => '营业执照identify.jpg'));
$enterprise->setPowerAttorney(array('name' => '授权委托书name', 'identify' => '授权委托书identify.jpg'));
$enterprise->setContactsInfo(
	new Sdk\Enterprise\Model\ContactsInfo(
		'联系人姓名',
		'13202938747',
		'联系地区',
		'联系地址打算打算的大大帅'
	)
);
$enterprise->setLegalPersonInfo(
	new Sdk\Enterprise\Model\LegalPersonInfo(
		'张三三',
		'61052719980821009X',
		array('name' => 'name', 'identify' => '1.jpg'),
		array('name' => 'name', 'identify' => '2.jpg'),
		array('name' => 'name', 'identify' => '3.jpg')
	)
);
$enterprise->setMember($member);

// var_dump($enterprise->add()); //done
//var_dump($enterpriseObject->scenario($enterpriseObject::FETCH_ONE_MODEL_UN)->fetchOne(1)); //done
//var_dump($enterpriseObject->scenario($enterpriseObject::OA_LIST_MODEL_UN)->fetchList(array(1,2))); //done
// var_dump($enterprise->edit());


$unAuditedEnterprise = new Sdk\Enterprise\Model\UnAuditedEnterprise();

$unAuditedEnterprise->setId(8);
$unAuditedEnterprise->setName('企信云');
$unAuditedEnterprise->setUnifiedSocialCreditCode('13249487367XX');
$unAuditedEnterprise->setLogo(array('name' => '企业LOGOname', 'identify' => '企业LOGOidentify.jpg'));
$unAuditedEnterprise->setBusinessLicense(array('name' => '营业执照name', 'identify' => '营业执照identify.jpg'));
$unAuditedEnterprise->setPowerAttorney(array('name' => '授权委托书name', 'identify' => '授权委托书identify.jpg'));
$unAuditedEnterprise->setContactsInfo(
	new Sdk\Enterprise\Model\ContactsInfo(
		'联系人姓名',
		'13202938747',
		'联系地区哈哈',
		'联系地址哈哈哈'
	)
);
$unAuditedEnterprise->setLegalPersonInfo(
	new Sdk\Enterprise\Model\LegalPersonInfo(
		'张三三',
		'61052719980821009X',
		array('name' => 'name', 'identify' => '1.jpg'),
		array('name' => 'name', 'identify' => '2.jpg'),
		array('name' => 'name', 'identify' => '3.jpg')
	)
);
// $unAuditedEnterprise->setMember($member);
//$unAuditedEnterprise->setRejectReason('hhhhhhhhhhh');

//var_dump($unAuditedEnterpriseObject->scenario($unAuditedEnterpriseObject::FETCH_ONE_MODEL_UN)->fetchOne(8)); //done
//var_dump($unAuditedEnterpriseObject->scenario($unAuditedEnterpriseObject::OA_LIST_MODEL_UN)->fetchList(array(1,2,3))); //done
var_dump($unAuditedEnterprise->resubmit()); //done
 //var_dump($unAuditedEnterprise->approve()); //done
//var_dump($unAuditedEnterprise->reject()); //done
