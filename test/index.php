<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$iblock_id = Bitrix\Main\Config\Option::get('crm', 'default_product_catalog_id');

if ($_GET['add_prop']) {
	$p_size = (new CIBlockProperty)->Add([
		'NAME' => 'Deal award size',
		'ACTIVE' => 'Y',
		'SORT' => 500,
		'CODE' => 'UF_CRM_DEAL_AWARD_SIZE',
		'PROPERTY_TYPE' => 'N',
		'IBLOCK_ID' => $iblock_id,
	]);

	$p_type = (new CIBlockProperty)->Add([
		'NAME' => 'Deal award type',
		'ACTIVE' => 'Y',
		'SORT' => 500,
		'CODE' => 'UF_CRM_DEAL_AWARD_TYPE',
		'PROPERTY_TYPE' => 'L',
		'IBLOCK_ID' => $iblock_id,
	]);
	$option1 = (new CIBlockPropertyEnum)->Add([
		'PROPERTY_ID' => $p_type,
		'VALUE' => 'absolute',
	]);
	$option2 = (new CIBlockPropertyEnum)->Add([
		'PROPERTY_ID' => $p_type,
		'VALUE' => 'percent',
	]);
	$option3 = (new CIBlockPropertyEnum)->Add([
		'PROPERTY_ID' => $p_type,
		'VALUE' => 'difference',
	]);
}



if (isset($_GET['del_prop'])) {

	$option1 = CIBlockPropertyEnum::GetList([], [
		'VALUE' => 'absolute',
	])->Fetch();
	$delete1 = CIBlockPropertyEnum::Delete($option1['ID']);

	$option2 = CIBlockPropertyEnum::GetList([], [
		'VALUE' => 'percent',
	])->Fetch();
	$delete2 = CIBlockPropertyEnum::Delete($option2['ID']);

	$option3 = CIBlockPropertyEnum::GetList([], [
		'VALUE' => 'difference',
	])->Fetch();
	$delete3 = CIBlockPropertyEnum::Delete($option3['ID']);

	$p_size = CIBlockProperty::GetList([
		'CODE' => 'UF_CRM_DEAL_AWARD_SIZE'
	])->Fetch();
	$delete_size = CIBlockProperty::Delete($p_size['ID']);

	$p_type = CIBlockProperty::GetList([
		'CODE' => 'UF_CRM_DEAL_AWARD_TYPE'
	])->Fetch();
	$delete_type = CIBlockProperty::Delete($p_type['ID']);
	

}


?>

<pre><?php print_r($delete_type); ?></pre>