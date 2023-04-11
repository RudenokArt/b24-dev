<?php 

/**
 * 
 */
class klimsol_tickets extends CModule
{

	var $MODULE_ID = 'klimsol.tickets';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct () {
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2023-04-10 12:00:00';
		$this->MODULE_NAME = 'klimsol.tickets';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}
	
	function DoInstall() {
		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/install.sql');
		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {
		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/uninstall.sql');
		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}
}


?>