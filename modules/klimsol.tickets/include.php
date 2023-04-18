<?php

\Bitrix\Main\Loader::RegisterAutoLoadClasses(
  'klimsol.tickets', [
    'Bitrix\Klimsol\FaqTable' => 'libs/FaqTable.php',
    'Bitrix\Klimsol\TicketsFaqRest' => 'libs/TicketsFaqRest.php',
  ]
);

?>