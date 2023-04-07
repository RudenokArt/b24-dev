<?php
IncludeModuleLangFile(__FILE__);

class Lisenkov_DomPDF extends CModule {

	var $MODULE_ID = 'lisenkov.dompdf';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_GROUP_RIGHTS = 'N';


	function __construct() {

		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2022-02-11 12:00:00';
		$this->MODULE_NAME = GetMessage('LISENKOV_DOMPDF_MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('LISENKOV_DOMPDF_MODULE_DESCRIPTION');
		$this->PARTNER_NAME = 'lisenkov';
		$this->PARTNER_URI = '';

	}

	function DoInstall() {

		RegisterModule($this->MODULE_ID);

		$GLOBALS['APPLICATION']->IncludeAdminFile(GetMessage('LISENKOV_DOMPDF_INSTALL_SUCCESS'), __DIR__ . '/step.php');

	}

	function DoUninstall() {

		UnRegisterModule($this->MODULE_ID);

		$GLOBALS['APPLICATION']->IncludeAdminFile(GetMessage('LISENKOV_DOMPDF_INSTALL_SUCCESS'), __DIR__ . '/unstep.php');

	}

}

?>