<?php 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
\Bitrix\Main\Loader::includeModule('crm');
\Bitrix\Main\Loader::includeModule('docbrown.tinkoff');
CJSCore::Init(array("jquery"));

$currency_src = CCurrency::GetList();	
while ($currency_item = $currency_src->fetch()) {
	$arResult['currency_list'][$currency_item['NUMCODE']] = $currency_item['CURRENCY'];
}

if ($_GET['update']) {
	$arResult['operation'] = \Bitrix\Docbrown\TinkoffTable::getList([
		'filter' => ['ID' => $_GET['update'],],
	])->fetch();
} else {
	$this->init($arResult['currency_list']);
	$arResult['total'] = $this->total;
	$arResult['nav'] = $this->nav;
	$arResult['operationsList'] = $this->data['operationsList'];
	$arResult['filter'] = $this->filter;
}



$this->IncludeComponentTemplate();
?>