<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arr = [1,];
unset($arr[0]);
var_dump(array_pop($arr));