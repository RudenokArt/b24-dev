<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Bitrix\Main\Loader::includeModule('tasks');
new PrivateOfficeTickets();

/**
 * 
 */
class PrivateOfficeTickets {
	
	function __construct() {
		if (isset($_POST['add'])) {
			(new CTasks)->Add([
				'TITLE' => 'Neue Anfrage für Deal #'.$_POST['deal'],
				'DESCRIPTION' => $this->taskDescription($_POST),
				'RESPONSIBLE_ID' => $_POST['responsible'],
				'CREATED_BY' => 1,
				'UF_CRM_TASK' => ['D_'.$_POST['deal'],],
				'XML_ID' => 'D_'.$_POST['deal'],
				'PRIORITY' => 1,
			]);
		}
		if (isset($_POST['getList'])) {
			$this->data['tickets'] = \Bitrix\Tasks\TaskTable::getList([
				'filter' => [
					'UF_CRM_TASK' => 'D_'.$_POST['deal'],
					'XML_ID' => 'D_'.$_POST['deal'],
				],
				'order' => ['ID' => 'DESC',],
				'select' => [
					'*', 'UF_*',
					'ID',
					'TITLE',
					'DESCRIPTION',
					'STATUS'
				],
			])->fetchAll();
			echo json_encode($this->data['tickets'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}
	}

	function taskDescription ($arr) {
		return '<b>Service Grund: </b>'.$arr['reason'].'<br>
		<b>Priorität: </b>'.$arr['priority'].'<br>
		'.$arr['remark'];
	}

}

?>