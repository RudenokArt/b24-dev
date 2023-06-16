<?php 

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
  "docbrown:tinkoff",
  "",
  Array()
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>