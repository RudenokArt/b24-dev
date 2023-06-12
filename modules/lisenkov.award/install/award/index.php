<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

Bitrix\Main\Loader::includeModule('crm');

Bitrix\Main\Loader::includeModule('lisenkov.award');

$APPLICATION->includeComponent('award:users', '');

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>