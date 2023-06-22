<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Bitrix\Main\Loader::includeModule('crm');
$APPLICATION->SetTitle('deals-list');

$this->init($_SESSION['private_office']['contact']);
$arResult = $this->data;

$this->IncludeComponentTemplate();

?>