<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
\Bitrix\Main\Loader::includeModule('docbrown.tinkoff');
use Bitrix\Main\Engine\Controller;

class TinkoffCrmdController extends Controller {

	public static function unlinkCrmAction($id) {
		$item = \Bitrix\Docbrown\TinkoffTable::getList([
			'filter' => ['ID' => $id,],
		])->fetch();
		if ($item) {
			\Bitrix\Docbrown\TinkoffTable::update($item['ID'], [
				'CRM_ID' => '',
			]);
		}
		return \Bitrix\Docbrown\TinkoffTable::setPaymentProps($item);
	}

	public static function linkCrmAction($crm, $item) {
		$arr = explode('_', $crm);
		if ($arr[0] == 'L') {
			$e_type = 'LEAD_';
		} elseif ($arr[0] == 'D') {
			$e_type = 'DEAL_';
		}
		$tinkoff = \Bitrix\Docbrown\TinkoffTable::getList([
			'filter' => ['ID' => $item,],
		])->fetch();
		if ($tinkoff) {
			$update = \Bitrix\Docbrown\TinkoffTable::update($tinkoff['ID'], [
				'CRM_ID' => $e_type.$arr[1],
			]);
		}
		$tinkoff = \Bitrix\Docbrown\TinkoffTable::getList([
			'filter' => ['ID' => $item,],
		])->fetch();
		return \Bitrix\Docbrown\TinkoffTable::setPaymentProps($tinkoff);
	}
}
?>