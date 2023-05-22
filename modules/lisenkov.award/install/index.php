<?php
class Lisenkov_Award extends CModule {

	function __construct() {

		$this->MODULE_ID = getModuleId(__DIR__);
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2022-02-11 12:00:00';
		$this->MODULE_NAME = getMessage(toUpper(self::class) . '_MODULE_NAME');
		$this->MODULE_DESCRIPTION = getMessage(toUpper(self::class) . '_MODULE_DESCRIPTION');
		$this->PARTNER_NAME = 'lisenkov';
		$this->PARTNER_URI = '';
		$this->MODULE_GROUP_RIGHTS = 'N';

	}

	function doInstall() {

		$this->installDB();
		$this->installFiles();
		$this->registerDependences();
		$this->installOther();
		registerModule($this->MODULE_ID);

		$GLOBALS['APPLICATION']->includeAdminFile(getMessage(toUpper(self::class) . '_INSTALL_SUCCESS'), __DIR__ . '/step.php');

	}

	function doUninstall() {

		if (!$GLOBALS['step']) {

			$GLOBALS['APPLICATION']->includeAdminFile(getMessage(toUpper(self::class) . '_MODULE_REMOVING'), __DIR__ . '/unstep1.php');

		} else {

			if (!$_REQUEST['savedata']) $this->unInstallDB();
			$this->unInstallFiles();
			$this->unRegisterDependences();
			$this->unInstallOther();
			unRegisterModule($this->MODULE_ID);

			$GLOBALS['APPLICATION']->includeAdminFile(getMessage(toUpper(self::class) . '_INSTALL_SUCCESS'), __DIR__ . '/unstep2.php');

		}

	}

	function installDB() {

		$GLOBALS['DB']->runSQLBatch(__DIR__ . '/db/install.sql');

	}

	function unInstallDB() {

		$GLOBALS['DB']->runSQLBatch(__DIR__ . '/db/uninstall.sql');

	}

	function installFiles() {

		copyDirFiles(__DIR__ . '/components', $_SERVER['DOCUMENT_ROOT'] . '/' . $this->getCurrentDir() . '/components/', true, true);
		copyDirFiles(__DIR__ . '/award', $_SERVER['DOCUMENT_ROOT'] . '/award/', true, true);

	}

	function unInstallFiles() {

		deleteDirFilesEx('/' . $this->getCurrentDir() . '/components/award');
		deleteDirFilesEx('/award');

	}

	function registerDependences() {

		registerModuleDependences('tasks', 'OnTaskUpdate', $this->MODULE_ID, '\\Bitrix\\Lisenkov\\Award', 'accrueAward');

	}

	function unRegisterDependences() {

		unRegisterModuleDependences('tasks', 'OnTaskUpdate', $this->MODULE_ID, '\\Bitrix\\Lisenkov\\Award', 'accrueAward');

	}

	function installOther() {

		Bitrix\Main\Config\Option::set(
			$this->MODULE_ID,
			'TaskAwardFieldID',
			(new CUserTypeEntity)->add([
				'ENTITY_ID' => 'TASKS_TASK',
				'FIELD_NAME' => 'UF_TASKS_TASK_LISENKOV_AWARD',
				'USER_TYPE_ID' => 'money',
				'EDIT_FORM_LABEL' => [
					'ru' => getMessage(toUpper(self::class) . '_MODULE_NAME', null, 'ru'),
					'en' => getMessage(toUpper(self::class) . '_MODULE_NAME', null, 'en'),
					'de' => getMessage(toUpper(self::class) . '_MODULE_NAME', null, 'de'),
				]
			])
		);

		Bitrix\Main\Config\Option::set('intranet', 'left_menu_preset', 'custom');

		$items = unserialize(
			Bitrix\Main\Config\Option::get('intranet', 'left_menu_custom_preset_items')
		);
		$items[$this->MODULE_ID] = ['LINK' => '/award/', 'TEXT' => getMessage(toUpper(self::class) . '_MODULE_NAME')];

		Bitrix\Main\Config\Option::set('intranet', 'left_menu_custom_preset_items', serialize($items));

	}

	function unInstallOther() {

		(new CUserTypeEntity)->delete(Bitrix\Main\Config\Option::get($this->MODULE_ID, 'TaskAwardFieldID'));

		Bitrix\Main\Config\Option::delete($this->MODULE_ID);

		$items = unserialize(
			Bitrix\Main\Config\Option::get('intranet', 'left_menu_custom_preset_items')
		);
		unset($items[$this->MODULE_ID]);

		Bitrix\Main\Config\Option::set('intranet', 'left_menu_custom_preset_items', serialize($items));

	}

	function getCurrentDir() {

		return strstr(__DIR__, 'local') ? 'local' : 'bitrix';

	}

}

?>