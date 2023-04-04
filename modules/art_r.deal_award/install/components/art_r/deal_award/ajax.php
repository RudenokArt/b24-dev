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
	'filter'=> json_decode($filter, true),
]);
$rsData = $rsData;
$arr = [];
foreach ($rsData as $key => $value) {
	$user = CUser::GetByID($value['UF_USER_ID'])->Fetch();
	$value['user'] = $user['NAME'] . ' ' . $user['LAST_NAME'];
	$value['date'] = ConvertTimeStamp($value['UF_AWARD_TIME']);
	$value['deal'] = CCrmDeal::GetListEx([],['ID'=>$value['UF_DEAL_ID']])->Fetch()['TITLE'];
	array_push($arr, $value);
}


$html = '<style>
table {
	margin: auto;
	border-collapse: collapse;
	font-family: Arial;
}
td, th {
	border: 1px solid grey;
	padding: 10px;
}
th {
	font-weight: bold;
	text-align: center;
}
</style>
<table>
<tr>
<th><b>ID</b></th>
<th>'.$_POST['table_head_user'].'</th>
<th>'.$_POST['table_head_deal'].'</th>
<th>'.$_POST['table_head_amount'].'</th>
<th>'.$_POST['table_head_date'].'</th>
</tr>
';


foreach ($arr as $key => $value) {
	$html = $html . '
	<tr>
	<td>' . $value['ID'] . '</td>
	<td>' . $value['user'] . '</td>
	<td>' . $value['deal'] . '</td>
	<td>' . $value['UF_AWARD_AMOUNT'] . '</td>
	<td>' . $value['date'] . '</td>
	</tr>
	';
}

$html = $html . '</table>';

include_once 'dompdf/index.php';

?>