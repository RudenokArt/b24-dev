<?php 

namespace Bitrix\Docbrown;
use Dompdf\Dompdf;
use CFile;


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

	public static $tinkoffOperationFields = [
		'operationDate' => 'Дата операции',
		'operationId' => 'id операции',
		'accountNumber' => 'Номер счета',
		'bic' => 'БИК',
		'typeOfOperation' => 'Тип операции',
		'category' => 'Категория',
		'trxnPostDate' => '',
		'authorizationDate' => 'Дата авторизации',
		'drawDate' => '',
		'chargeDate' => 'Дата начисления',
		'docDate' => 'Дата документа',
		'payVo' => '',
		'vo' => '',
		'operationAmount' => 'Сумма операции',
		'operationCurrencyDigitalCode' => 'Код валюты операции',
		'accountAmount' => 'Сумма счета',
		'accountCurrencyDigitalCode' => 'Код валюты счета',
		'rubleAmount' => 'Рублевая сумма',
		'description' => 'Описание',
		'payPurpose' => 'Назначение платежа',
		'payer_acct' => 'Счет плательщика',
		'payer_inn' => 'ИНН плательщика',
		'payer_kpp' => 'КПП плательщика',
		'payer_name' => 'Плательщик',
		'payer_bicRu' => 'БИК плательщика',
		'payer_corAcct' => 'Корреспондентский счет плательщика',
		'receiver_acct' => 'Счет получателя',
		'receiver_inn' => 'ИНН получателя',
		'receiver_name' => 'Получатель',
		'receiver_bicRu' => 'БИК получателя',
		'receiver_corAcct' => 'Корреспондентский счет получателя',
		'counterParty_account' => 'Счет контрагента',
		'counterParty_inn' => 'ИНН контрагента',
		'counterParty_kpp' => 'КПП контрагента',
		'counterParty_name' => 'Контрагент',
		'counterParty_bankName' => 'Банк контрагента',
		'counterParty_bankBic' => 'БИК контрагента',
		'counterParty_corrAccount' => 'Корреспондентский счет контрагента',
		'cardNumber' => '№ карты',
		'ucid' => '',
		'mcc' => '',
		'rrn' => '',
	];

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
						'bic' => $value1['bic'],
						'typeOfOperation' =>$value1['typeOfOperation'],
						'category' => $value1['category'],
						'trxnPostDate' => self::dateToTime($value1['trxnPostDate']),
						'authorizationDate' => self::dateToTime($value1['authorizationDate']),
						'drawDate' => self::dateToTime($value1['drawDate']),
						'chargeDate' => self::dateToTime($value1['chargeDate']),
						'docDate' => self::dateToTime($value1['docDate']),
						'payVo' => $value1['payVo'],
						'vo' => $value1['vo'],
						'operationAmount' => $value1['operationAmount'],
						'operationCurrencyDigitalCode' => $value1['operationCurrencyDigitalCode'],
						'accountAmount' => $value1['accountAmount'],
						'accountCurrencyDigitalCode' => $value1['accountCurrencyDigitalCode'],
						'rubleAmount' => $value1['rubleAmount'],
						'description' => $value1['description'],
						'payPurpose' => $value1['payPurpose'],
						'payer_acct' => $value1['payer']['acct'],
						'payer_inn' => $value1['payer']['inn'],
						'payer_kpp' => $value1['payer']['kpp'],
						'payer_name' => $value1['payer']['name'],
						'payer_bicRu' => $value1['payer']['bicRu'],
						'payer_corAcct' => $value1['payer']['corAcct'],
						'receiver_acct' => $value1['receiver']['acct'],
						'receiver_inn' => $value1['receiver']['inn'],
						'receiver_name' => $value1['receiver']['name'],
						'receiver_bicRu' => $value1['receiver']['bicRu'],
						'receiver_corAcct' => $value1['receiver']['corAcct'],
						'counterParty_account' => $value1['counterParty']['account'],
						'counterParty_inn' => $value1['counterParty']['inn'],
						'counterParty_kpp' => $value1['counterParty']['kpp'],
						'counterParty_name' => $value1['counterParty']['name'],
						'counterParty_bankName' => $value1['counterParty']['bankName'],
						'counterParty_bankBic' => $value1['counterParty']['bankBic'],
						'counterParty_corrAccount' => $value1['counterParty']['corrAccount'],
						'cardNumber' => $value1['cardNumber'],
						'ucid' => $value1['ucid'],
						'mcc' => $value1['mcc'],
						'rrn' => $value1['rrn'],
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
			$pdf_id = self::pdfGenerator($value);
			\Bitrix\Docbrown\TinkoffTable::setPaymentProps($value['crm']);
			$value['CRM_ID'] = self::checkCrmId($value['crm']);
			$value['PDF'] = $pdf_id;
			unset($value['crm']);
			$add = TinkoffTable::validatedAdd($value);
			$arr[] = $add;
		}
		return $arr;
	}

	public static function pdfGenerator ($arr) {
		$payment = new Dompdf();
		$html = self::htmlGenerator($arr);
		$payment->loadHtml($html);
		$payment->render();
		$tmp_path = $_SERVER['DOCUMENT_ROOT'].'/upload/tmp/invoice.pdf';
		file_put_contents($tmp_path, $payment->output());
		$file_arr =  CFile::MakeFileArray($tmp_path);
		$file_id = CFile::SaveFile(
			array_merge($file_arr, ['del' => 'N', 'MODULE_ID' => 'main', ]),
			'tmp'
		);
		return $file_id;
	}

	public static function htmlGenerator ($arr) {
		$html = '<style>
		.statement-row {
			font-size: 10px;
		}
		.statement-row td {
			border-bottom: 1px solid rgba(0, 0, 0, 0.1);
		}
		.statement-container {
			padding: 10px;
			border: 1px solid rgba(0, 0, 0, 0.1);
			margin: auto;
			width: 100%;
			font-family: Arial;
		}
		</style>';
		$html = $html.'<table class="statement-container">';
		$html = $html.'<tr><td colspan="2"><img src="'.__DIR__.'/img/tink-logo.jpg" width="250"></td></tr>';
		foreach ($arr as $key => $value) {
			if ($key != 'crm') {
				$html = $html.'<tr class="statement-row">';
				if (self::$tinkoffOperationFields[$key]) {
					$html = $html.'<td><b>'.self::$tinkoffOperationFields[$key].'</b></td><td>'. $value;
				} else {
					$html = $html.'<td><b>'.$key.'</b></td><td>'. $value;
				}
				$html = $html . '</tr>';
			}
		}
		$html = $html . '</table>';
		return $html;
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
			$last_time = $operation['operationDate'];
		} else {
			$last_time = strtotime('2023-06-01');
		}
		$last_date = date('Y-m-d',$last_time).'T'.date('H:i:s',$last_time).'Z';
		return $last_date;
	}

}


