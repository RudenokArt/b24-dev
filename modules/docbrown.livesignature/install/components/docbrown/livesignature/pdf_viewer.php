<? 
define('NOT_CHECK_PERMISSIONS', true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent(
    "bitrix:pdf.viewer",
    "",
    Array(
        "IFRAME" => "Y",
        "PATH" => $_GET['path'],
    )
);?>