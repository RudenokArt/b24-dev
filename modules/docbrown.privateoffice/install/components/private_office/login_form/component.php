<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Bitrix\Main\Loader::includeModule('crm');
$APPLICATION->SetTitle('login');

if (isset($_GET['logout'])) {
	unset($_SESSION['private_office']['contact']);
}

if (isset($_POST['login']) and isset($_POST['password'])) {
	$this->init($_POST['login'], $_POST['password']);
}
$arResult = $this->loginForm;

if ($_SESSION['private_office']['contact']) {
	header('Location: /');
}

$this->IncludeComponentTemplate();

?>