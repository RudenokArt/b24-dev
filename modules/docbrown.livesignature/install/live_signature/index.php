<?php

define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
  "docbrown:livesignature",
  "",
  Array()
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");

?>