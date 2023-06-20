<?php 

namespace Bitrix\Docbrown;

/**
 * 
 */
class TinkoffRest {
	
	function OnRestServiceBuildDescription () {
		return array(
			'crm' => array(
				'tinkoff.statement' => array(
					'callback' => array(__CLASS__, 'statement'),
					'options' => array(),
				),
			)
		);
	}

	function statement () {
		$last_time = self::checkDate();
		$api = new TinkoffApi($last_time);
		foreach ($api->statements as $key => $value) {
			foreach ($value['operations'] as $key1 => $value1) {
				if ($value1['typeOfOperation'] == 'Credit') {
					preg_match_all('#LEAD_[0-9]+|DEAL_[0-9]+#', $value1['payPurpose'], $matches);
					$operations[] = [
						'operationDate' => self::dateToTime($value1['operationDate']),
						'operationId' => $value1['operationId'],
						'accountNumber' => $value1['accountNumber'],
						'operationAmount' => $value1['operationAmount'],
						'operationCurrencyDigitalCode' => $value1['operationCurrencyDigitalCode'],
						'payPurpose' => $value1['payPurpose'],
						'payer' => $value1['payer']['name'],
						'crm' => $matches[0][0],
					];
				}
			}
		}
		$add = self::saveData($operations);
		return [
			'errors' => $add,
			'operations' => $operations,
			'last_time' => $last_time,
			'db_data' => $list,
			'bank_data' => $api->statements,
		];
	}

		public static function checkCrmId ($crm) {
		\Bitrix\Main\Loader::includeModule('crm');
		$arr = explode('_', $crm);
		if ($arr[0] == 'LEAD') {
			$check = \Bitrix\Crm\LeadTable::getList([
				'filter' => ['ID' => $arr[1],],
			])->fetch();		
		} elseif ($arr[0] == 'DEAL') {
			$check = \Bitrix\Crm\DealTable::getList([
				'filter' => ['ID' => $arr[1],],
			])->fetch();
		}
		if ($check) {
			return $crm;
		}
		return null;
	}

	public static function saveData ($operations) {
		foreach ($operations as $key => $value) {
			$crm = self::checkCrmId($value['crm']);
			$add = TinkoffTable::validatedAdd([
				'DATE'=> $value['operationDate'],
				'OPERATION_ID'=> $value['operationId'],
				'ACCOUNT'=> $value['accountNumber'],
				'AMOUNT'=> $value['operationAmount'],
				'CURRENCY'=> $value['operationCurrencyDigitalCode'],
				'PURPOSE'=> $value['payPurpose'],
				'PAYER'=> $value['payer'],
				'CRM_ID'=> $crm,
			]);
			$arr[] = $add;
			\Bitrix\Docbrown\TinkoffTable::setPaymentProps($value['crm']);
		}
		return $arr;
	}

	function dateToTime ($str) {
		$arr = explode('T', $str);
		return strtotime($arr[0].' '.str_replace('Z', '', $arr[1]));
	}

	public static function checkDate () {
		$operation = TinkoffTable::getList([
			'order' => ['ID' => 'DESC'],
		])->fetch();
		if ($operation) {
			$last_time = $operation['DATE'];
		} else {
			$last_time = strtotime('2023-06-01');
		}
		$last_date = date('Y-m-d',$last_time).'T'.date('H:i:s',$last_time).'Z';
		return $last_date;
	}

}


?>