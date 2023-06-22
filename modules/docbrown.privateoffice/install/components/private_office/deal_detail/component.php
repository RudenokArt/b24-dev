<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Bitrix\Main\Loader::includeModule('crm');
$APPLICATION->SetTitle('deal-detail');
\Bitrix\Main\UI\Extension::load("ui.vue");

$this->init(\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQuery('id'));
$arResult = $this->data;

$this->IncludeComponentTemplate();

?>