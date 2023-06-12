<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
CJSCore::Init(array("jquery"));
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
use Bitrix\UI\Toolbar\Facade\Toolbar;
$APPLICATION->setTitle($arResult['TITLE']);

Bitrix\UI\Toolbar\Facade\Toolbar::deleteFavoriteStar();


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
		'SHOW_ROW_CHECKBOXES' => true,
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
		'SHOW_CHECK_ALL_CHECKBOXES' => true,
		'SHOW_ROW_ACTIONS_MENU'     => false,
		'SHOW_GRID_SETTINGS_MENU'   => true,
		'SHOW_NAVIGATION_PANEL'     => true,
		'SHOW_PAGINATION'           => true,
		'SHOW_SELECTED_COUNTER'     => false,
		'SHOW_TOTAL_COUNTER'        => true,
		'SHOW_PAGESIZE'             => true,
		'SHOW_ACTION_PANEL'         => true,
		'ALLOW_COLUMNS_SORT'        => true,
		'ALLOW_COLUMNS_RESIZE'      => true,
		'ALLOW_HORIZONTAL_SCROLL'   => true,
		'ALLOW_SORT'                => true,
		'ALLOW_PIN_HEADER'          => true,
		'AJAX_OPTION_HISTORY'       => 'N',
		'ACTION_PANEL' => [
			'GROUPS' => [
				[
					'ITEMS' => [
						[
							'TYPE' => Bitrix\Main\Grid\Panel\Types::CUSTOM,
							'ID' => 'example-custom',
							'NAME' => 'EXAMPLE_CUSTOM',
							'VALUE' => '<button class="ui-btn ui-btn-danger" id="cancel_award_button">'.getMessage('cancel_premium').'</button>',
						],
					],
				],
			],
		],
	]
);
?>

<pre><?php print_r($arResult['debug']) ?></pre>

<script>

	$(function () {

		$('body').on('click','#cancel_award_button',function  () {
			console.log('click');
			$('#cancel_award_button').addClass('ui-btn-wait');
			var gridObject = BX.Main.gridManager.getById("<?php echo $arResult['GRID_ID'];?>");
			var rowsArr = gridObject.instance.rows.rows;
			var awardsArr = [];
			for (var i = 0; i < rowsArr.length; i++) {
				if ($(rowsArr[i].checkbox).prop('checked')) {
					awardsArr.push($(rowsArr[i].checkbox).prop('value'));
				}
			}

			var jsonArr = JSON.stringify(awardsArr);

			BX.ajax.runComponentAction(
				'award:detail',
				'CancelAwardItem',
				{
					mode: 'ajax',
					data: {
						json: jsonArr,
					},
				}
				).then(function (result){
					// console.log(result.data);
					$('#cancel_award_button').removeClass('ui-btn-wait');
					top.BX.Award.Users.reloadGrid();
				});

			});

	});

</script>
