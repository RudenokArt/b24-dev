<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$list = \Bitrix\Crm\DealTable::getList();

?>
<pre><?php // print_r($delete->getErrorMessages()); ?></pre>
<pre><?php print_r($list); ?></pre>
<pre><?php // print_r(get_class_methods($add)); ?></pre>