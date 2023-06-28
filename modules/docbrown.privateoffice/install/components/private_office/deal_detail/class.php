<?php

/**
 *
 */
class DealDetail extends CBitrixComponent {

	function init ($deal_id) {
		$this->data['deal'] = \Bitrix\Crm\DealTable::getList([
			'filter' => ['ID' => $deal_id,],
			'select' => [
				'ID',
				'DATE_CREATE',
				'DATE_MODIFY',
				'TITLE',
				'STAGE_ID',
				'CATEGORY_ID',
				'TYPE_ID',
				'CURRENCY_ID',
				'OPPORTUNITY',
				'COMMENTS',
				'BEGINDATE',
				'CLOSEDATE',
				'LAST_ACTIVITY_TIME',
				'ASSIGNED_BY_ID'
			],
		])->fetch();

		$this->data['status_list'] = Bitrix\Crm\StatusTable::getList([
			'filter'=>['CATEGORY_ID' => $this->data['deal']['CATEGORY_ID'],],
		])->fetchAll();

		$this->data['FAQ_list'] = $this->getFAQList();

		$this->data['deal_fields'] = $this->getDealFieldsArr();
	}

	function getFAQList () {
		$iblock_id = \Bitrix\Iblock\IblockTable::getList([
			'filter' => [
				'CODE' => 'FAQ',
				'IBLOCK_TYPE_ID'=>'services'
			],
			'select'=> ['ID'],
		])->fetch();

		$list = \Bitrix\Iblock\ElementTable::getList([
			'filter' => [
				'IBLOCK_ID' => $iblock_id,
			],
			'select' => ['ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT',],
		])->fetchAll();

		return $list;
	}

	function getDealFieldsArr () {
		global $USER;
		$USER->Authorize(1);
		$arr = CCrmRestService::onRestServiceMethod([], false, new CRestServer(['METHOD' => 'crm.deal.fields']));
		$USER->logout();
		return $arr;
	}

}

?>