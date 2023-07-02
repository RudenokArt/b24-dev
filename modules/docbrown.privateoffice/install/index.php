<?php

/**
 *
 */
class docbrown_privateoffice extends CModule
{

	var $MODULE_ID = 'docbrown.privateoffice';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct () {
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2023-06-12 12:00:00';
		$this->MODULE_NAME = 'docbrown.privateoffice';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}

	function DoInstall() {

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/install.sql');

		$this->installContactFields();

		$this->iBlockInstall();

		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {

		$GLOBALS['DB']->RunSqlBatch(__DIR__.'/db/uninstall.sql');
		
		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}

	function iBlockInstall () {
		$iblock_check = \Bitrix\Iblock\IblockTable::getList([
			'filter' => [
				'CODE' => 'FAQ',
				'IBLOCK_TYPE_ID'=>'services'
			],
		])->fetch();

		if (!$iblock_check) {
			$add = \Bitrix\Iblock\IblockTable::add([
				'IBLOCK_TYPE_ID' => 'services',
				'LID' => 's1',
				'CODE' => 'FAQ',
				'NAME' => 'FAQ',
				'ACTIVE' => 'Y',
				'SORT' => 500,
				'DESCRIPTION' => 'FAQ for private office',
				'WORKFLOW' => 'N',
			]);
		}
	}

	function installContactFields () {

		$oUserTypeEntity = new CUserTypeEntity();
		$aUserFields_log = array(
			'ENTITY_ID' => 'CRM_CONTACT',
			'FIELD_NAME' => 'UF_USER_LOGIN',
			'USER_TYPE_ID' => 'string',
			'MULTIPLE'=> 'N',
			'EDIT_FORM_LABEL' => array(
				'ru' => 'Логин для личного кабинета',
				'en' => 'Login for private office',
				'de' => 'Login für Privatkabinett',
			),
			'LIST_COLUMN_LABEL' => array(
				'ru' => 'Логин для личного кабинета',
				'en' => 'Login for private office',
				'de' => 'Login für Privatkabinett',
			),
		);
		$oUserTypeEntity->Add( $aUserFields_log ); 

		$aUserFields_pas = array(
			'ENTITY_ID' => 'CRM_CONTACT',
			'FIELD_NAME' => 'UF_USER_PASSWORD',
			'USER_TYPE_ID' => 'string',
			'MULTIPLE'=> 'N',
			'EDIT_FORM_LABEL' => array(
				'ru' => 'Пароль для личного кабинета',
				'en' => 'Password for private office',
				'de' => 'Passwort für Privatkabinett',
			),
			'LIST_COLUMN_LABEL' => array(
				'ru' => 'Пароль для личного кабинета',
				'en' => 'Password for private office',
				'de' => 'Passwort für Privatkabinett',
			),
		);
		$oUserTypeEntity->Add( $aUserFields_pas ); 

	}


}


?>