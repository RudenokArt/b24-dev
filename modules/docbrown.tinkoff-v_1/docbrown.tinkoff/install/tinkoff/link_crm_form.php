<?php 

// require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
  'bitrix:ui.sidepanel.wrapper',
  '',
  [
    'POPUP_COMPONENT_NAME' => 'docbrown:tinkoff',
    'POPUP_COMPONENT_TEMPLATE_NAME' => 'link_crm_form',
    'POPUP_COMPONENT_PARAMS' => []
  ]
);



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>