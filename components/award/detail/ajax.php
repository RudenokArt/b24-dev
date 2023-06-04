<?php 

if (isset($_POST['cancel_award'])) {
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule('lisenkov.award');
	$cancel_award = new CancelAward($_POST['cancel_award']);
	print_r($cancel_award->tasks_list);
}

/**
 * 
 */
class CancelAward {
	
	function __construct($json) {

		$this->awards_id_arr = json_decode($json);

		$this->awards_list = Bitrix\Lisenkov\AwardTable::getList([
			'filter' => [
				'ID' => $this->awards_id_arr,
			],
			'select' => ['TASK'],
		])->fetchAll();

		$this->tasks_id_arr = $this->getTasksIdArr();

		$this->tasks_list = $tasks_list = Bitrix\Tasks\TaskTable::getList([
			'filter' => [
				'ID' => $this->tasks_id_arr,
			],
			'select' => ['ID', 'UF_TASKS_TASK_LISENKOV_AWARD'],
		])->fetchAll();

	}

	function getTasksIdArr() {
		foreach ($this->awards_list as $key => $value) {
			$arr[] = $value['TASK_ID'];
		}
		return $arr;
	}


}

?>