<?php

namespace Bitrix\Lisenkov;

use Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator,
	Bitrix\Main\Type\DateTime;

class AwardTable extends DataManager {

	public static function getTableName() {
		return 'b_lisenkov_award';
	}

	public static function getMap() {
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => 'ID'
				]
			),
			new IntegerField(
				'USER_ID',
				[
					'title' => 'USER_ID'
				]
			),
			new DatetimeField(
				'DATE',
				[
					'default' => function()
					{
						return new DateTime();
					},
					'title' => 'DATE'
				]
			),
			new IntegerField(
				'TASK',
				[
					'title' => 'TASK'
				]
			),
			new StringField(
				'AWARD',
				[
					'validation' => [__CLASS__, 'validateAward'],
					'title' => 'AWARD',
					'save_data_modification' => function() {
	                    return [
	                        function($obj) {
	                            return base64_encode(serialize($obj));
	                        }
	                    ];
	                },
	                'fetch_data_modification' => function() {
	                    return [
	                        function($str) {
	                            return unserialize(base64_decode($str));
	                        }
	                    ];
	                }
				]
			),
		];
	}

	public static function validateAward() {
		return [
			new LengthValidator(null, 255),
		];
	}

	public static function getList($params = [], bool $getCount = false) {
		$select = ['T.TITLE', 'T.UF_CRM_TASK', 'T.UF_TASKS_TASK_LISENKOV_AMOUNT'];
		$params['select'] = $params['select'] ? array_merge($params['select'], $select) : array_merge(['*'], $select);
		$params['runtime'] = [
			'T' => [
				'data_type' => \Bitrix\Tasks\Internals\TaskTable::getEntity(),
				'reference' => [
					'=this.TASK' => 'ref.ID'
				]
			]
		];
		$result = parent::getList($params);
		if ($getCount) {
			$result->setCount(parent::getList([
				'select' => ['TOTAL'],
				'filter' => $params['filter'] ?: [],
				'runtime' => [
					new \Bitrix\Main\Entity\ExpressionField('TOTAL', 'COUNT(*)')
				]
			])->fetch()['TOTAL']);
		}
		$result->addFetchDataModifier(function(&$data) {
			$data['TASK_ID'] = $data['TASK'];
			$data['TASK_TITLE'] = $data['LISENKOV_AWARD_T_TITLE'];
			$data['AMOUNT'] = $data['LISENKOV_AWARD_T_UF_TASKS_TASK_LISENKOV_AMOUNT'];
			$data['TASK_CRM'] = $data['LISENKOV_AWARD_T_UF_CRM_TASK'];
			$data['TASK'] = '<a href="/company/personal/user/' . $GLOBALS['USER']->GetID() . '/tasks/task/view/' . $data['TASK_ID'] . '/" onclick="event.stopPropagation()">' . $data['TASK_TITLE'] . '</a>';
			unset($data['LISENKOV_AWARD_T_ID']);
			unset($data['LISENKOV_AWARD_T_TITLE']);
			unset($data['LISENKOV_AWARD_T_UF_CRM_TASK']);
			unset($data['LISENKOV_AWARD_T_UF_TASKS_TASK_LISENKOV_AMOUNT']);
		});
		return $result;
	}

}

?>