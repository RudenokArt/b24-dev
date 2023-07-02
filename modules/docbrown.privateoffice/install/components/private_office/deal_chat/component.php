<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Bitrix\Main\Loader::includeModule('im');
Bitrix\Main\Loader::includeModule('Imopenlines');
Bitrix\Main\Loader::includeModule('crm');
\Bitrix\Main\Loader::includeModule('docbrown.privateoffice');

$this->init($arParams);
$arResult = $this->data;

$this->IncludeComponentTemplate();

?>