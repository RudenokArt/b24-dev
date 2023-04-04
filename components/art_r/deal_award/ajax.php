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
}
td {
	border: 1px solid grey;
	padding: 10px;
}
</style>
<table>';

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

<style>
	table {
		margin: auto;
		border-collapse: collapse;
	}
	td {
		border: 1px solid grey;
		padding: 10px;
	}
</style>
<table>
	<?php foreach ($arr as $key => $value): ?>
		<tr>
			<td>
				<?php echo $value['ID']; ?>
			</td>
			<td>
				<?php echo $value['user']; ?>
			</td>
			<td>
				<?php echo $value['deal']; ?>
			</td>
			<td>
				<?php echo $value['UF_AWARD_AMOUNT']; ?>
			</td>
			<td>
				<?php echo $value['date']; ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<pre><?php print_r(json_decode($filter, true)); ?></pre>