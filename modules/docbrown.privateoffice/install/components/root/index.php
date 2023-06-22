<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Private-office');
$APPLICATION->IncludeComponent(
  "private_office:deals_list",
  "",
  Array()
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>