<?php
$arUrlRewrite = [
	0 => [ 
		"CONDITION" => "#^/deal/([A-z-0-9]+)/?#",
		"RULE" => "id=$1",
		"PATH" => "/deal/index.php",
	], 
];

?>
