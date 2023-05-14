<?php 

/**
 * 
 */
class art_r_live_signature extends CModule
{

	var $MODULE_ID = 'art_r.live_signature';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct () {
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2023-05-10 12:00:00';
		$this->MODULE_NAME = 'art_r.live_signature';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}
	
	function DoInstall() {
		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/install.sql');
		RegisterModuleDependences('documentgenerator', 'onBeforeProcessDocument',
			$this->MODULE_ID, '\Live\DocumentGeneratorHandler', 'customizeDocument');
    $this->InstallFiles();
		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {
		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/uninstall.sql');
    $this->UnInstallFiles();
    UnRegisterModuleDependences('documentgenerator', 'onBeforeProcessDocument',
			$this->MODULE_ID, '\Live\DocumentGeneratorHandler', 'customizeDocument');
		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}

	function InstallFiles()
	{
		CopyDirFiles(__DIR__.'/components/art_r/live_signature/',
			$_SERVER["DOCUMENT_ROOT"]."/local/components/art_r/live_signature/", true, true);
		CopyDirFiles(__DIR__."/live_signature/", $_SERVER["DOCUMENT_ROOT"]."/live_signature/", true, true);
		CopyDirFiles(__DIR__."/activities/custom/live_signature/",
			$_SERVER["DOCUMENT_ROOT"]."/local/activities/custom/live_signature/", true, true);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/components/art_r/live_signature/");
		DeleteDirFilesEx("/live_signature/");
		DeleteDirFilesEx("/activities/custom/live_signature/");
		return true;
	}


}


?>