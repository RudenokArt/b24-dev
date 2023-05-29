<?php

/**
 *
 */
class docbrown_livesignature extends CModule
{

	var $MODULE_ID = 'docbrown.livesignature';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct () {
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2023-05-20 12:00:00';
		$this->MODULE_NAME = 'docbrown.livesignature';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}

	function DoInstall() {

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/install.sql');

		$this->InstallFiles();

		RegisterModuleDependences(
			'main', 'onBeforeProlog',	$this->MODULE_ID, '\Bitrix\Livesignature\Pdf', 'init'
		);

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/install.sql');
		RegisterModuleDependences('documentgenerator', 'onBeforeProcessDocument',
			$this->MODULE_ID, '\Bitrix\Livesignature\DocumentGeneratorHandler', 'customizeDocument');

		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/uninstall.sql');

		$this->UnInstallFiles();

		UnRegisterModuleDependences(
			'main', 'onBeforeProlog', $this->MODULE_ID, '\Bitrix\Livesignature\Pdf', 'init'
		);

		UnRegisterModuleDependences('documentgenerator', 'onBeforeProcessDocument',
			$this->MODULE_ID, '\Bitrix\Livesignature\DocumentGeneratorHandler', 'customizeDocument');

		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}


	function InstallFiles()
	{
		CopyDirFiles(
			__DIR__.'/live_signature/',
			$_SERVER['DOCUMENT_ROOT'].'/live_signature/', true, true
		);
		CopyDirFiles(
			__DIR__.'/upload/livesignature/',
			$_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/', true, true
		);
		CopyDirFiles(
			__DIR__.'/activities/custom/live_signature/',
			$_SERVER['DOCUMENT_ROOT'].'/local/activities/custom/live_signature/', true, true
		);
		CopyDirFiles(
			__DIR__.'/components/docbrown/livesignature/',
			$_SERVER['DOCUMENT_ROOT'].'/local/components/docbrown/livesignature/', true, true
		);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx('/live_signature/');
		DeleteDirFilesEx('/upload/livesignature/');
		DeleteDirFilesEx('/local/activities/custom/live_signature/');
		DeleteDirFilesEx('/local/components/docbrown/livesignature/');
		return true;
	}

	


}


?>