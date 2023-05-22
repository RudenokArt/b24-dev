<?php
class AwardDetailComponent extends CBitrixComponent {

	private $date = false;

	protected function getTitle() {

		$title = CUser::formatName(
			CSite::getNameFormat(),
			CUser::getById($this->arParams['USER_ID'])->fetch(),
			true,
			false
		);

		if ($this->arParams['DATE_FROM'] !== '' && $this->arParams['DATE_TO'] !== ''){

			$this->date = true;

			$title .= ' [' . new Bitrix\Main\Type\Date($this->arParams['DATE_FROM']) . ' - ' . new Bitrix\Main\Type\Date($this->arParams['DATE_TO']) . ']';

		} else {

			$title .= ' [' . getMessage('AWARD_DETAIL_ALL_TIME') . ']';

		}

		return $title;

	}

	protected function getFilter() {

		$filter['USER_ID'] = $this->arParams['USER_ID'];

		if ($this->date) {

			$filter['><DATE'] = [
				$this->arParams['DATE_FROM'],
				$this->arParams['DATE_TO']
			];

		}

		return $filter;

	}

}
?>