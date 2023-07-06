<?php 

\Bitrix\Main\Loader::RegisterAutoLoadClasses(
  'docbrown.tinkoff', [
    'Bitrix\Docbrown\TinkoffRest' => 'lib/TinkoffRest.php',
    'Bitrix\Docbrown\TinkoffApi' => 'lib/TinkoffApi.php',
    'Bitrix\Docbrown\TinkoffTable' => 'lib/TinkoffTable.php',
  ]
);

?>