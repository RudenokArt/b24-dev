<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::IncludeModule('highloadblock');

$filter = file_get_contents(__DIR__.'/filter.json');

$highload = \Bitrix\Highloadblock\HighloadBlockTable::getList([
			'filter'=>['TABLE_NAME' => 'deal_award',],
		])->Fetch();

$items = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highload);
$entity_data_class = $items->getDataClass();
$rsData = $entity_data_class::getList([
	'filter'=> json_decode($filter),
]);
$rsData = $rsData;
$arr = [];
foreach ($rsData as $key => $value) {
	array_push($arr, $value);
}

$html =  json_encode($arr);

include_once 'dompdf/index.php';

?>