<?php 
use Bitrix\UI\Toolbar\Facade\Toolbar;
\Bitrix\Main\UI\Extension::load("ui.buttons");
\Bitrix\Main\UI\Extension::load("ui.icons.b24");
Toolbar::DeleteFavoriteStar();
$APPLICATION->SetTitle('Tinkoff bank');
Toolbar::AddFilter([ 
	'FILTER_ID' => 'tinkoff_operations_filter', 
	'GRID_ID' => 'tinkoff_operations_list', 
	'FILTER' => [ 
		['id' => 'DATE', 'name' => GetMessage('DATE'), 'type' => 'date',],
		['id' => 'OPERATION_ID', 'name' => GetMessage('OPERATION_ID'), 'type' => 'string',],
		['id' => 'ACCOUNT', 'name' => GetMessage('ACCOUNT'), 'type' => 'string',],
		['id' => 'CURRENCY', 'name' => GetMessage('CURRENCY'), 'type' => 'list', 'items' => $arResult['currency_list'],],
		['id' => 'PURPOSE', 'name' => GetMessage('PURPOSE'), 'type' => 'string',],
		['id' => 'PAYER', 'name' => GetMessage('PAYER'), 'type' => 'string',],
		['id' => 'CRM_ID', 'name' => GetMessage('CRM_ID'), 'type' => 'string',],
	],
  'ENABLE_LIVE_SEARCH' => true, 
	'ENABLE_LABEL' => true,
	'DISABLE_SEARCH' => true,
]);

$tinkoffApiRequestButton = new \Bitrix\UI\Buttons\Button();
$tinkoffApiRequestButton->setText(GetMessage('Synchronization'));
$tinkoffApiRequestButton->addClass('ui-btn ui-btn-primary ui-btn-icon-cloud');
$tinkoffApiRequestButton->addClass('tinkoffApiRequestButton');
\Bitrix\UI\Toolbar\Facade\Toolbar::addButton($tinkoffApiRequestButton);


$APPLICATION->IncludeComponent(
	'bitrix:main.ui.grid',
	'',
	[
		'GRID_ID' => 'tinkoff_operations_list', 
		'COLUMNS' => [
			['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true], 
			['id' => 'DATE', 'name' => GetMessage('DATE'), 'sort' => 'DATE', 'default' => true],
			['id' => 'OPERATION_ID', 'name' => GetMessage('OPERATION_ID'), 'sort' => 'OPERATION_ID', 'default' => true],
			['id' => 'ACCOUNT', 'name' => GetMessage('ACCOUNT'), 'sort' => 'ACCOUNT', 'default' => true],
			['id' => 'AMOUNT', 'name' => GetMessage('AMOUNT'), 'sort' => 'AMOUNT', 'default' => true],
			['id' => 'CURRENCY', 'name' => GetMessage('CURRENCY'), 'sort' => 'CURRENCY', 'default' => true],
			['id' => 'PURPOSE', 'name' => GetMessage('PURPOSE'), 'sort' => 'PURPOSE', 'default' => true],
			['id' => 'PAYER', 'name' => GetMessage('PAYER'), 'sort' => 'PAYER', 'default' => true],
			['id' => 'CRM_ID', 'name' => GetMessage('CRM_ID'), 'sort' => 'CRM_ID', 'default' => true],
		], 
		'ROWS' => $arResult['operationsList'],
		'SHOW_ROW_CHECKBOXES' => false, 
		'NAV_OBJECT' => $arResult['nav'], 
		'AJAX_MODE' => 'Y', 
		'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''), 
		'PAGE_SIZES' => [ 
			['NAME' => "5", 'VALUE' => '5'], 
			['NAME' => '10', 'VALUE' => '10'], 
			['NAME' => '20', 'VALUE' => '20'], 
			['NAME' => '50', 'VALUE' => '50'], 
			['NAME' => '100', 'VALUE' => '100'] 
		], 
		'AJAX_OPTION_JUMP'          => 'N', 
		'SHOW_CHECK_ALL_CHECKBOXES' => true, 
		'SHOW_ROW_ACTIONS_MENU'     => true, 
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
		'AJAX_OPTION_HISTORY'       => 'N', 
		'TOTAL_ROWS_COUNT' => $arResult['total'],
	]
);


?>

<script>

	$(function () {
		$('.tinkoffApiRequestButton').click(function () {
			$('.tinkoffApiRequestButton').addClass('ui-btn-wait');
			$.post('https://crm.bluecardagency.de/rest/4350/xiz37zd661y60vcg/tinkoff.statement', {}, function (data) {
				console.log(data);
				Tinkoff.gridReload();
				$('.tinkoffApiRequestButton').removeClass('ui-btn-wait');
			});
		});
	});

	var Tinkoff = {

		unlinkCrm: function (item_id) {
			BX.ajax.runComponentAction(
				'docbrown:tinkoff',
				'unlinkCrm',
				{
					mode: 'ajax',
					data: {
						id: item_id,
					},
				}).then(function (result){
					console.log(result.data);
					Tinkoff.gridReload();
				});
			},

			gridReload: function () {
				var gridObject = BX.Main.gridManager.getById('tinkoff_operations_list');
				if (gridObject.hasOwnProperty('instance')){
					gridObject.instance.reloadTable('POST', {apply_filter: 'N', clear_nav: 'N'});
				}
			},

			linkCrm: function (item_id) {
				BX.SidePanel.Instance.open('link_crm_form.php?update='+item_id, {
					allowChangeHistory: false,
					width: 750,
				});
			}
		};

	</script>