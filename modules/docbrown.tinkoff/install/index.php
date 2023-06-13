<?php

/**
 *
 */
class docbrown_tinkoff extends CModule
{

	var $MODULE_ID = 'docbrown.tinkoff';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct () {
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2023-06-12 12:00:00';
		$this->MODULE_NAME = 'docbrown.tinkoff';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}

	function DoInstall() {

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/install.sql');

		RegisterModuleDependences('rest', 'OnRestServiceBuildDescription', 
			$this->MODULE_ID, 'Bitrix\Docbrown\TinkoffRest', 'OnRestServiceBuildDescription');

		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/uninstall.sql');

		UnRegisterModuleDependences('rest', 'OnRestServiceBuildDescription', 
			$this->MODULE_ID, 'Bitrix\Docbrown\TinkoffRest', 'OnRestServiceBuildDescription');

		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}

	


}


?>