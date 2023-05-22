<?php
class AwardUsersComponent extends CBitrixComponent {

	public $sort;
	public $find;
	public $date;
	public $users;

	public function setFilter($data, $sort, $pull = true) {

		$this->sort = $sort['sort']['USER'];

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

	}

	public function getAwards() {

		$baseCurrency = CCurrency::getBaseCurrency();

		$awards = Bitrix\Lisenkov\AwardTable::getList([
			'select' => ['USER_ID', 'AWARD'],
			'filter' => ['><DATE' => $this->date]
		])->fetchAll();

		foreach ($awards as $award) {

			$result[$award['USER_ID']] += $award['AWARD']->getConvertedAmount($baseCurrency);

		}

		$result[0] = 0;

		foreach ($result as $key => $award) {

			$result[$key] = '<span class="award">' . currencyFormat($award, $baseCurrency) . '</span>';

		}

		return $result;

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

			if ($this->users) $params['filter']['ID'] = $this->users;

		}

		$userModelList = Bitrix\Disk\User::getModelList($params);

		foreach ($userModelList as $user) {

			$users[$user->getId()] = $names ? $user->getFormattedName() : '<a class="award-user" href="' . $user->getDetailUrl() . '" onclick="event.stopPropagation()">
				<div class="ui-icon">
					<i style="background-image: url(\'' . $user->getAvatarSrc() . '\'); background-size: cover"></i>
				</div>
				<span class="award-username">' . $user->getFormattedName() . '</span>
			</a>';

		}

		return $users;

	}

}

?>