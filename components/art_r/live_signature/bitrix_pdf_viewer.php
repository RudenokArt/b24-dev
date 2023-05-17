<? define('NOT_CHECK_PERMISSIONS', true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowHead();
$APPLICATION->IncludeComponent(
		"bitrix:pdf.viewer",
		"",
		Array(
			"HEIGHT" => "600",
			"IFRAME" => "N",
			"PATH" => $_GET['path'],
			"PRINT" => "N",
			"PRINT_URL" => "",
			"TITLE" => "",
			"VIEWER_ID" => "",
			"WIDTH" => "600"
		)
	);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");

?>