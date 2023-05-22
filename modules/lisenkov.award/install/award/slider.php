<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

Bitrix\Main\Loader::includeModule('lisenkov.award');

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$date = json_decode($request->getQuery('filter'), true);

$params = $request->getQuery('userId') ? [
	'POPUP_COMPONENT_NAME' => 'award:detail',
	'POPUP_COMPONENT_PARAMS' => [
		'USER_ID' => $request->getQuery('userId'),
		'DATE_FROM' => $date['dateFrom'],
		'DATE_TO' => $date['dateTo'],
	]
] : [
	'POPUP_COMPONENT_NAME' => 'award:report',
	'POPUP_COMPONENT_PARAMS' => [
		'EXCEL' => $request->getQuery('excel'),
		'PDF' => $request->getQuery('pdf'),
		'JPG' => $request->getQuery('jpg'),
		'DATE_FROM' => $date['dateFrom'],
		'DATE_TO' => $date['dateTo'],
	]
];

$APPLICATION->includeComponent(
	'bitrix:ui.sidepanel.wrapper',
	'',
	array_merge($params, [
		'POPUP_COMPONENT_TEMPLATE_NAME' => '',
		'POPUP_COMPONENT_USE_BITRIX24_THEME' => 'Y',
		'USE_UI_TOOLBAR' => 'Y'
	])
);
?>