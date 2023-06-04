<?php
class AwardUsersComponent extends CBitrixComponent {

	public $sort;
	public $find;
	public $date;
	public $users;

	public function setFilter($data, $sort, $pull = true) {

		if ($sort['sort']['USER']) {
			$this->sort = $sort['sort']['USER'];
		}	else {
			$this->sort = 'desc';
			$this->award_sort = $sort;
		}



		if (!empty($data['FIND'])) {

			$this->find = $data['FIND'];

		}

		if (!empty($data['USER'])) {

			foreach ($data['USER'] as $user) {

				$this->users[] = substr($user, 1);

			}

		}

		if (!empty($data['DATE_datesel'])) {

			$this->date = [$data['DATE_from'], $data['DATE_to']];

		}

		if(Bitrix\Main\Loader::includeModule('pull') && $pull){

			CPullStack::addByUser($GLOBALS['USER']->getId(), [
				'module_id' => 'lisenkov.award',
				'command' => 'APPLY_FILTER',
				'params' => [
					'DATE_from' => $data['DATE_from'] ?: '',
					'DATE_to' => $data['DATE_to'] ?: '',
					'SORT' => $sort,
					'FILTER_DATA' => $data
				]
			]);

		}

		if ($data['deal']) {
			$this->deal_filter = $this->awardDealFilter($data['deal']);
		}

	}

	public function awardDealFilter ($deal_id) {
		$tasks_list = Bitrix\Tasks\TaskTable::getList([
			'filter' => [
				'UF_CRM_TASK' => $deal_id,
			],
			'select' => ['ID'],
		])->fetchAll();
		foreach ($tasks_list as $key => $value) {
			$task_arr[] = $value['ID'];
		}
		return $task_arr;
	}

	public function getAwards($period=false) {

		$baseCurrency = CCurrency::getBaseCurrency();

		$filter = ['><DATE' => $this->date];

		if ($period == 'previous_30_days') {
			$filter = [
				'><DATE' => [
					date('d.m.Y 00:00:00', strtotime('-30 days')),
					date('d.m.Y 00:00:00'),
				],
			];
		}

		if ($period == 'previous_month') {
			$filter = [
				'><DATE' => [
					date('01.m.Y 00:00:00', strtotime('-1 month')),
					date('t.m.Y 23:59:59', strtotime('-1 month')),
				],
			];
		}

		if ($this->deal_filter) {
			$filter['TASK'] = $this->deal_filter;
		}

		$awards = Bitrix\Lisenkov\AwardTable::getList([
			'select' => [
				'USER_ID',
				'AWARD'
			],
			'filter' => $filter,
		])->fetchAll();


		foreach ($awards as $award) {

			$result[$award['USER_ID']] += $award['AWARD']->getConvertedAmount($baseCurrency);

		}

		$result[0] = 0;

		$this->awards_list = $result;

		foreach ($result as $key => $award) {

			$result[$key] = '<span class="award">' . currencyFormat($award, $baseCurrency) . '</span>';

		}

		$this->dealsSelect = $this->getDealsSelect();

		return $result;

	}

	public function getDealsSelect () {
		$awards = Bitrix\Lisenkov\AwardTable::getList([
			'filter' => ['><DATE' => $this->date],
		])->fetchAll();
		foreach ($awards as $key => $value) {
			if ($value['TASK_CRM']) {
				$deals[] =  $value['TASK_CRM'][0];
			}
		}
		$deals = array_unique($deals);
		$arr = [];
		foreach ($deals as $key => $value) {
			$deal_id = explode('_', $value)[1];
			$deal = Bitrix\Crm\DealTable::getList([
				'filter' => ['ID' => $deal_id,],
			])->fetch();
			// $arr[$value] = $deal['ID'].'-'.$deal['TITLE'];
			$arr[] = [
				'id' => $value,
				'entityId' => 'deal',
				'title' => $deal['ID'].' | '.$deal['TITLE'],
				'tabs' => 'recents',
			];
		}
		return $arr;
	}

	public function getUsers($names = false) {

		$params['order'] = ['NAME' => $this->sort];

		if (!$GLOBALS['USER']->isAdmin()) {

			$params['filter']['ID'] = $GLOBALS['USER']->getId();

		} else {

			$params['filter'] = [
				'ACTIVE' => 'Y',
				'!UF_DEPARTMENT' => false, // intranet only
				[
					'LOGIC' => 'OR',
					['?EMAIL' => $this->find],
					['?LOGIN' => $this->find],
					['?NAME' => $this->find],
					['?LAST_NAME' => $this->find],
					['?SECOND_NAME' => $this->find],
					['?WORK_POSITION' => $this->find],
					['?WORK_DEPARTMENT' => $this->find],
					['?WORK_PHONE' => $this->find],
					['?PERSONAL_PHONE' => $this->find],
					['?PERSONAL_MOBILE' => $this->find]
				]
			];

			if ($this->users) {
				$params['filter']['ID'] = $this->users;
				$award_sort_filter = [
					'!UF_DEPARTMENT' => false,
					'ID' => $this->users,
				];
			} else {
				$award_sort_filter = [
					'!UF_DEPARTMENT' => false,
				];
			}

		}


		if (isset($this->award_sort['sort']['AWARD'])) { // if order by award

			$users_list = \Bitrix\Main\UserTable::getList([
				'select' => ['ID',],
				'filter' => $award_sort_filter,
			])->fetchAll();

			foreach ($users_list as $key => $value) {
				$award_users_list[$value['ID']] = $this->awards_list[$value['ID']];
			}

			if ($this->award_sort['sort']['AWARD'] == 'asc') {
				asort($award_users_list);
			} elseif ($this->award_sort['sort']['AWARD'] == 'desc') {
				arsort($award_users_list);
			}

			$sort_award_users_list = array_keys($award_users_list);

			$sort = implode(',', array_merge(['ID'], $sort_award_users_list));

			$userModelList = Bitrix\Disk\User::getModelList([
				'filter' => ['ID' => $sort_award_users_list],
				'order' => ['SORT'],
				'runtime' => [new Bitrix\Main\Entity\ExpressionField('SORT', 'FIELD(' . $sort . ')')]
			]);

			foreach ($userModelList as $user) {
				$users[$user->getId()] = $this->getHtmlUsersLink($names, $user);
			}

			// foreach ($sort_award_users_list as $key => $value) {
			// 	$user = Bitrix\Disk\User::GetByID($value);
			// 	$users[$value] = $this->getHtmlUsersLink($names, $user);
			// }

		} else {
			$userModelList = Bitrix\Disk\User::getModelList($params);
		}

		foreach ($userModelList as $user) {
			$users[$user->getId()] = $this->getHtmlUsersLink($names, $user);
		}

		return $users;

	}

	function getHtmlUsersLink ($names, $user) {
		return $names ? $user->getFormattedName() : '<a class="award-user" href="' . $user->getDetailUrl() . '" onclick="event.stopPropagation()">
		<div class="ui-icon">
		<i style="background-image: url(\'' . $user->getAvatarSrc() . '\'); background-size: cover"></i>
		</div>
		<span class="award-username">' . $user->getFormattedName() . '</span>
		</a>';
	}

}

?>