<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\UI\Buttons;

$arResult['GRID_ID'] = 'award_users_list';

if (Bitrix\Main\Loader::includeModule('lisenkov.phpoffice')) {

	$arResult['BUTTONS']['REPORT'] = new Buttons\Button([
		'color' => Buttons\Color::LIGHT_BORDER,
		'icon' => Buttons\Icon::TASK,
	    'click' => new Buttons\JsCode('BX.Award.Users.CreateReport(this)'),
	    'text' => getMessage('AWARD_USERS_REPORT')
	]);

	$arResult['BUTTONS']['REPORT']->setNoCaps();

}

$gridOptions = new Bitrix\Main\Grid\Options($arResult['GRID_ID']);
$arResult['SORT'] = $gridOptions->getSorting(['sort' => ['USER' => 'desc'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$navParams = $gridOptions->getNavParams();

$arResult['NAV'] = new Bitrix\Main\UI\PageNavigation($arResult['GRID_ID']);
$arResult['NAV']->allowAllRecords(true)->setPageSize($navParams['nPageSize'])->initFromUri();

$filterOption = new Bitrix\Main\UI\Filter\Options($arResult['GRID_ID']);
$arResult['FILTER_DATA'] = $filterOption->getFilter();

$this->setFilter($arResult['FILTER_DATA'], $arResult['SORT']);

$arResult['COLUMNS'] = [
	['id' => 'USER', 'name' => getMessage('AWARD_USERS_USER'), 'sort' => 'USER', 'default' => true],
	['id' => 'AWARD', 'name' => getMessage('AWARD_USERS_AWARD'), 'default' => true]
];

$arResult['FILTER'] = [
	['id' => 'DATE', 'name' => getMessage('AWARD_USERS_DATE'), 'default' => true, 'type' => 'date']
];

if ($USER->isAdmin()) {
	array_push($arResult['FILTER'], ['id' => 'USER', 'name' => getMessage('AWARD_USERS_USER'), 'default' => true, 'type' => 'dest_selector',
		'params' => ['multiple' => 'Y', 'enableDepartments' => 'N', 'userSearchArea' => 'I']
	]);
}

$arResult['ROWS'] = array();

$awards = $this->getAwards();

$users = $this->getUsers();

$arResult['TOTAL'] = count($users);

$users = array_slice($users, $arResult['NAV']->getOffset(), $arResult['NAV']->getLimit(), true);

$arResult['NAV']->setRecordCount($arResult['TOTAL']);

foreach ($users as $userId => $user) {

	$arResult['ROWS'][] = [
        'data' => [
			'ID' => $userId,
			'USER' => $user,
			'AWARD' => $awards[$userId] ?: $awards[0]
        ]
    ];

}

$arResult['DATESEL'] = $this->date;


$this->includeComponentTemplate();
?>