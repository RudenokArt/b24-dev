<?php
namespace Bitrix\Lisenkov;
use \Bitrix\Lisenkov\AwardTable;

class Award {

	private $amount;
	private $currency;
	private $date;

	private function __construct($award) {

		$award = explode('|', $award);

		$this->amount = array_shift($award);
		$this->currency = array_shift($award);
		$this->date = date('Y-m-d');

	}

    public static function accrueAward($ID, $arFields) {

		if ($arFields['META:PREV_FIELDS']['UF_TASKS_TASK_LISENKOV_AWARD']) {

			if ((int) $arFields['STATUS'] === 5) {

				$award = new self($arFields['META:PREV_FIELDS']['UF_TASKS_TASK_LISENKOV_AWARD']);

				if ($awardId = AwardTable::getList(['select' => ['ID'], 'filter' => ['TASK' => $ID]])->fetch()['ID']) {

					AwardTable::update($awardId, [
						'USER_ID' => $arFields['META:PREV_FIELDS']['RESPONSIBLE_ID'],
						'AWARD' => $award
					]);

				} else {

					AwardTable::add([
						'TASK' => $ID,
						'USER_ID' => $arFields['META:PREV_FIELDS']['RESPONSIBLE_ID'],
						'AWARD' => $award
					]);

				}

			}

		}

    }

	public function __toString() {

		return currencyFormat($this->amount,  $this->currency);

	}

	public function getConvertedAmount($baseCurrency) {

		if ($this->currency !== $baseCurrency) {

			return \CCurrencyRates::convertCurrency($this->amount,  $this->currency, $baseCurrency, $this->date);

		} else {

			return $this->amount;

		}

	}

}
?>