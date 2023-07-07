<?php 
CModule::includeModule('lisenkov.dompdf');
\Bitrix\Main\Loader::includeModule('currency');
\Bitrix\Main\Loader::includeModule('crm');
\Bitrix\Main\Loader::includeModule('main');
\Bitrix\Main\Loader::RegisterAutoLoadClasses(
  'docbrown.tinkoff', [
    'Bitrix\Docbrown\TinkoffRest' => 'lib/TinkoffRest.php',
    'Bitrix\Docbrown\TinkoffApi' => 'lib/TinkoffApi.php',
    'Bitrix\Docbrown\TinkoffTable' => 'lib/TinkoffTable.php',
  ]
);

?>