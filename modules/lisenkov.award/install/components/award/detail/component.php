<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['GRID_ID'] = 'award_detail_list';

$arResult['TITLE'] = $this->getTitle();

$gridOptions = new Bitrix\Main\Grid\Options($arResult['GRID_ID']);
$sort = $gridOptions->getSorting(['sort' => ['ID' => 'asc'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$navParams = $gridOptions->getNavParams();

$arResult['NAV'] = new Bitrix\Main\UI\PageNavigation($arResult['GRID_ID']);
$arResult['NAV']->allowAllRecords(true)->setPageSize($navParams['nPageSize'])->initFromUri();

$params = [
	'select' => ['ID', 'DATE', 'TASK', 'AWARD'],
	'filter' => $this->getFilter(),
	'offset' => $arResult['NAV']->getOffset(),
	'limit' => $arResult['NAV']->getLimit(),
	'order' => $sort['sort']
];


if ($arParams['DEAL']) {
	$params['filter']['TASK'] = $this->awardDealFilter($arParams['DEAL']);
}


$awards = Bitrix\Lisenkov\AwardTable::getList($params, true);

$arResult['TOTAL'] = $awards->getCount();

$arResult['NAV']->setRecordCount($arResult['TOTAL']);

$arResult['COLUMNS'] = [
	['id' => 'ID', 'name' => getMessage('AWARD_DETAIL_ID'), 'sort' => 'ID', 'default' => true],
	['id' => 'DATE', 'name' => getMessage('AWARD_DETAIL_DATE'), 'sort' => 'DATE', 'default' => true],
	['id' => 'TASK', 'name' => getMessage('AWARD_DETAIL_TASK'), 'sort' => 'TASK', 'default' => true],
	['id' => 'AWARD', 'name' => getMessage('AWARD_DETAIL_AWARD'), 'sort' => 'AWARD', 'default' => true],
	['id' => 'DEAL', 'name' => getMessage('AWARD_DETAIL_DEAL'), 'default' => true],
	['id' => 'AMOUNT', 'name' => getMessage('AMOUNT'), 'default' => true],
];

$arResult['ROWS'] = array();

foreach ($awards->fetchAll() as $award) {

	if ($award['TASK_CRM'][0]) {
		$deal = $award['TASK_CRM'][0];
		$deal_id = explode('_', $deal)[1];
		$deal_arr = Bitrix\Crm\DealTable::getList([
			'filter' => ['ID' => $deal_id,],
		])->fetch();
		$arResult['deals'][$deal] = $deal_arr['ID'].' | '.$deal_arr['TITLE'];
	} else {
		$deal = null;
	}
	$award_amount = explode('|', $award['AMOUNT']);
	$arResult['ROWS'][] = [
		'data' => [
			'ID' => $award['ID'],
			'DATE' => $award['DATE'],
			'TASK' => $award['TASK'],
			'AWARD' => $award['AWARD'],
			'DEAL' => '<a href="/crm/deal/details/'.$deal_id.'/" data-entity="deal" data-deal="'.$deal_id.'">'.$arResult['deals'][$deal].'</a>',
			'AMOUNT' => CurrencyFormat($award_amount[0], $award_amount[1]),
		]
	];

}


$this->includeComponentTemplate();
?>
