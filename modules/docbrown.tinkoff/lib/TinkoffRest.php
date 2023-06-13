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
		return [
			'last_time' => $last_time,
			'db_data' => $list,
			'bank_data' => $api->statements
		];
	}

	public static function checkDate () {
		$operation = TinkoffTable::getList([
			'order' => ['ID' => 'DESC'],
		])->fetch();
		if ($operation) {
			$last_time = $operation['DATE'];
		} else {
			$last_time = strtotime('2023-01-01');
		}
		$last_date = date('Y-m-d',$last_time).'T'.date('H:i:s',$last_time).'Z';
		return $last_date;
	}

}


?>