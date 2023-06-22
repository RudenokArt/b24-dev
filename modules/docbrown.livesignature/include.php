<?php

\Bitrix\Main\Loader::RegisterAutoLoadClasses(
  'docbrown.livesignature', [
	'Bitrix\Livesignature\Pdf' => 'lib/Pdf.php',
  'Bitrix\Livesignature\LivesignatureTable' => 'lib/LivesignatureTable.php',
  'Bitrix\Livesignature\DocumentGeneratorHandler' => 'lib/DocumentGeneratorHandler.php',
  ]
);

?>