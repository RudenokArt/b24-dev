<?php

use Bitrix\Main\Loader;

Loader::includeModule('tasks');
Loader::includeModule('currency');

Loader::registerAutoLoadClasses(
    getModuleId(__DIR__), [
		'Bitrix\Lisenkov\Award' => 'lib/Award.php',
		'Bitrix\Lisenkov\AwardTable' => 'lib/AwardTable.php'
    ]
);

?>