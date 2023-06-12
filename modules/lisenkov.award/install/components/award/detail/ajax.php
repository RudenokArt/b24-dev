<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Engine\Controller;

class CancelAwardController extends Controller {

	public static function CancelAwardItemAction($json) {
		CModule::IncludeModule('lisenkov.award');
		$cancel_award = new CancelAward($json);
		return $cancel_award;
	}
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

		// $this->tasks_list = Bitrix\Tasks\TaskTable::getList([ // for debug only
		// 	'filter' => ['ID' => $this->tasks_id_arr,],
		// ])->fetchAll();

		foreach ($this->tasks_id_arr as $key => $value) {
			$update = Bitrix\Tasks\TaskTable::update($value, [
				'STATUS' => 2,
			]);
		}

		foreach ($this->awards_id_arr as $key => $value) {
			Bitrix\Lisenkov\AwardTable::delete($value);
		}

	}

	function getTasksIdArr() {
		foreach ($this->awards_list as $key => $value) {
			$arr[] = (int) $value['TASK_ID'];
		}
		return $arr;
	}


}

?>