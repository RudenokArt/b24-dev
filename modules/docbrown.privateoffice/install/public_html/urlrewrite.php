<?php
$arUrlRewrite = [
	0 => [
		"CONDITION" => "#^/deal/([A-z-0-9]+)/?#",
		"RULE" => "id=$1",
		"PATH" => "/deal/index.php",
	],
	[
      'CONDITION' => '#^/rest/#',
      'RULE' => '',
      'ID' => NULL,
      'PATH' => '/bitrix/services/rest/index.php',
      'SORT' => 100,
	],
];

?>
