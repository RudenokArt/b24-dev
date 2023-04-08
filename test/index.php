<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

COption::SetOptionString('intranet', 'left_menu_preset', 'custom');
$menu_items_arr = unserialize(COption::GetOptionString('intranet', 'left_menu_custom_preset_items'));
$menu_items_arr['art_r.deal_award'] = ['LINK' => '/deal_award/', 'TEXT' => 'deal_award'];
COption::SetOptionString('intranet', 'left_menu_custom_preset_items', serialize($menu_items_arr));

$menu_items_arr = unserialize(COption::GetOptionString('intranet', 'left_menu_custom_preset_items'));
unset($menu_items_arr['art_r.deal_award']);
COption::SetOptionString('intranet', 'left_menu_custom_preset_items', serialize($menu_items_arr));

?>

<pre><?php print_r($menu_items_arr) ?></pre>