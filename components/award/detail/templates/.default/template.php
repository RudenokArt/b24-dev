<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
CJSCore::Init(array("jquery"));
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
use Bitrix\UI\Toolbar\Facade\Toolbar;
$APPLICATION->setTitle($arResult['TITLE']);

Bitrix\UI\Toolbar\Facade\Toolbar::deleteFavoriteStar();

$cancel_award_button = new \Bitrix\UI\Buttons\Button([
	'text' => getMessage('CANCEL').' '.getMessage('AWARD_DETAIL_AWARD'),
]);
Toolbar::addButton($cancel_award_button);
$cancel_award_button->addClass('ui-btn-default');
$cancel_award_button->addClass('ui-btn-icon-alert');
$cancel_award_button->addClass('cancel_award_button');

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

	$(function () {

		var award_arr = [];

		$('.cancel_award_button').click(function () {
			$.post("<?php echo $this->getComponent()->getPath();?>/ajax.php", {
				cancel_award: JSON.stringify(award_arr)
			}, function (data) {
				console.log(data);
			});
		});


		$('input[name="cancel_award"]').change(function () {
			var flag = false;
			var arr = $('input[name="cancel_award"]');
			award_arr = [];
			for (var i = 0; i < arr.length; i++) {
				if (arr[i].checked) {
					award_arr.push(arr[i].value);
					flag = true;
				}
			}
			if (flag) {
				$('.cancel_award_button').addClass('ui-btn-danger');
			} else {
				$('.cancel_award_button').removeClass('ui-btn-danger');
			}
		});


	});

</script>
