<?php

\Bitrix\Main\Loader::RegisterAutoLoadClasses(
  'art_r.live_signature', [
    'Bitrix\Live\SignatureTable' => 'libs/SignatureTable.php',
    'Live\DocumentGeneratorHandler' => 'libs/DocumentGeneratorHandler.php',
	'Bitrix\Live\Pdf' => 'libs/Pdf.php'
  ]
);

?>