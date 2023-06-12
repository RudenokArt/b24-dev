<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\UI\Toolbar\Facade\Toolbar;

$APPLICATION->setTitle(getMessage('AWARD_USERS_TITLE'));

Toolbar::deleteFavoriteStar();

Toolbar::addFilter([
	'GRID_ID' => $arResult['GRID_ID'],
	'FILTER_ID' => $arResult['GRID_ID'],
	'FILTER' => $arResult['FILTER'],
	'ENABLE_LIVE_SEARCH' => true,
	'ENABLE_LABEL' => true,
	'DISABLE_SEARCH' => $USER->isAdmin() ? false : true
]);

foreach($arResult['BUTTONS'] as $button) {

	Toolbar::addButton($button);

}

$APPLICATION->includeComponent(
	'bitrix:main.ui.grid',
	'',
	[
		'GRID_ID' => $arResult['GRID_ID'],
		'COLUMNS' => $arResult['COLUMNS'],
		'ROWS' => $arResult['ROWS'],
		'FOOTER' => [
			'TOTAL_ROWS_COUNT' => $arResult['TOTAL'],
		],
		'SHOW_ROW_CHECKBOXES' => false,
		'NAV_OBJECT' => $arResult['NAV'],
		'AJAX_MODE' => 'Y',
		'PAGE_SIZES' => [
			['NAME' => '5', 'VALUE' => '5'],
			['NAME' => '10', 'VALUE' => '10'],
			['NAME' => '20', 'VALUE' => '20'],
			['NAME' => '50', 'VALUE' => '50'],
			['NAME' => '100', 'VALUE' => '100']
		],
		'AJAX_OPTION_JUMP'          => 'N',
		'SHOW_CHECK_ALL_CHECKBOXES' => false,
		'SHOW_ROW_ACTIONS_MENU'     => false,
		'SHOW_GRID_SETTINGS_MENU'   => true,
		'SHOW_NAVIGATION_PANEL'     => true,
		'SHOW_PAGINATION'           => true,
		'SHOW_SELECTED_COUNTER'     => false,
		'SHOW_TOTAL_COUNTER'        => true,
		'SHOW_PAGESIZE'             => true,
		'SHOW_ACTION_PANEL'         => false,
		'ALLOW_COLUMNS_SORT'        => true,
		'ALLOW_COLUMNS_RESIZE'      => true,
		'ALLOW_HORIZONTAL_SCROLL'   => true,
		'ALLOW_SORT'                => true,
		'ALLOW_PIN_HEADER'          => true,
		'AJAX_OPTION_HISTORY'       => 'N'
	]
);
?>


<script>

	BX.ready(function () {

		BX.Award.Users.Grid = BX.Main.gridManager.getInstanceById('<?=$arResult['GRID_ID']?>');

		BX.addCustomEvent('Grid::updated', BX.Award.Users.UpdateRows);
		BX.Award.Users.UpdateRows();

		BX.Award.Users.DATE_from = '<?=$arResult['DATESEL'][0]?>';
		BX.Award.Users.DATE_to = '<?=$arResult['DATESEL'][1]?>';
		BX.Award.Users.SORT = <?=json_encode($arResult['SORT'])?>;
		BX.Award.Users.FILTER_DATA = <?=json_encode($arResult['FILTER_DATA'])?>;

		BX.Award.Users.ajaxIsAllowed = true;

	});

</script>

<pre><?php print_r($arResult['debug']); ?></pre>