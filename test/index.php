<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$delete = \Bitrix\Iblock\IblockTable::delete(18);

$iblock_check = \Bitrix\Iblock\IblockTable::getList([
	'filter' => [
		'CODE' => 'FAQ',
		'IBLOCK_TYPE_ID'=>'services'
	],
])->fetch();

// if (!$iblock_check) {
// 	$add = \Bitrix\Iblock\IblockTable::add([
// 		'IBLOCK_TYPE_ID' => 'services',
// 		'LID' => 's1',
// 		'CODE' => 'FAQ',
// 		'NAME' => 'FAQ',
// 		'ACTIVE' => 'Y',
// 		'SORT' => 500,
// 		'DESCRIPTION' => 'FAQ for private office',
// 	]);
// }


?>

<pre><?php // print_r($delete->getErrorMessages()); ?></pre>
<pre><?php print_r($iblock_check); ?></pre>
<pre><?php // print_r(get_class_methods($add)); ?></pre>