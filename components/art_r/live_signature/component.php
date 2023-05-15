<?php 

if (isset($_POST['pdf_for_iframe'])) {
	echo file_exists($_POST['pdf_for_iframe']);
	exit();
}

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// include_once 'vendor/autoload.php';
CModule::includeModule('lisenkov.phpoffice');
CModule::IncludeModule('art_r.live_signature');
\Bitrix\Main\Loader::includeModule('documentgenerator');

$this->init();

$arResult = $this->live_signature;

$arResult['alert'] = false;

if (isset($_POST['password'])) {
	if ($_POST['password'] == $arResult['signature']['PASSWORD']) {
		$_SESSION['live_signature'] = $arResult['signature']['ID'];
	} else {
		$arResult['alert'] = true;
	}
} 

$this->IncludeComponentTemplate();
?>