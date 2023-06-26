<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
  "private_office:login_form",
  "",
  Array()
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>