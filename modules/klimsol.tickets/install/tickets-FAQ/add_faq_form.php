<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
    'bitrix:ui.sidepanel.wrapper',
    '',
    [
        'POPUP_COMPONENT_NAME' => 'klimsol:tickets_faq',
        'POPUP_COMPONENT_TEMPLATE_NAME' => 'add_faq_form',
        'PAGE_MODE' => false,
        'USE_UI_TOOLBAR' => 'Y',
        'RELOAD_PAGE_AFTER_SAVE' => true,
        // 'POPUP_COMPONENT_PARAMS' => [
        //     'PATH_TO_BUTTON_LIST' => $arResult['PATH_TO_BUTTON_LIST'],
        //     'PATH_TO_BUTTON_EDIT' => $arResult['PATH_TO_BUTTON_EDIT'],
        //     'PATH_TO_BUTTON_FILL' => $arResult['PATH_TO_BUTTON_FILL'],
        //     'PATH_TO_USER_PROFILE' => $arResult['PATH_TO_USER_PROFILE'],
        //     'ELEMENT_ID' => $arResult['VARIABLES']['id']
        // ]
    ]
);

?>

