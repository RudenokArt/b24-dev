<?php 

\Bitrix\Main\Loader::RegisterAutoLoadClasses(
  'otpusk.bigtrip', [
    'Bitrix\Otpusk\BigtripRest' => 'lib/BigtripRest.php',
  ]
);

?>