<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Bitrix\Main\Loader::includeModule('crm');
$APPLICATION->SetTitle('profile');

$this->init();
$arResult = $this->data;

$this->IncludeComponentTemplate();

?>