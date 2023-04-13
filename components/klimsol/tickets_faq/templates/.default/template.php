<?php 
\CJSCore::init("sidepanel");
CJSCore::Init(array("jquery"));
use Bitrix\UI\Toolbar\Facade\Toolbar;
Toolbar::DeleteFavoriteStar();
$ticket_faq_save_button = new \Bitrix\UI\Buttons\Button([
	'text' => GetMessage('add_question'),
	'icon' => \Bitrix\UI\Buttons\Icon::ADD,
	'color' => \Bitrix\UI\Buttons\Color::SUCCESS,
]);
$ticket_faq_save_button->addClass('open_add_faq_form');
\Bitrix\UI\Toolbar\Facade\Toolbar::addButton($ticket_faq_save_button);

$APPLICATION->IncludeComponent(
	'bitrix:main.ui.grid',
	'',
	[
		'GRID_ID' => 'klimsol_tickets_faq_grid', 
		'COLUMNS' => [   
			['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true], 
			['id' => 'DATE', 'name' =>  GetMessage('date'), 'sort' => 'DATE', 'default' => true],
			['id' => 'QUESTION', 'name' => GetMessage('question'), 'sort' => 'QUESTION', 'default' => true], 
			['id' => 'ANSWER', 'name' => GetMessage('answer'), 'sort' => 'ANSWER', 'default' => true], 
		], 
		'ROWS' => $arResult->getGridFAQList(),
		'SHOW_ROW_CHECKBOXES' => false, 
		'NAV_OBJECT' => $arResult->nav, 
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
		'ROW_ACTIONS_MENU' => [],
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
		'CURRENT_PAGE' => 5,
		'TOTAL_ROWS_COUNT' => $arResult->faq_count,
	]
);

?>

<pre>кол. <?php print_r($arResult->faq_count);?></pre>
<pre>кол на стр. <?php print_r($arResult->page_size);?></pre>
<pre>стр. <?php print_r($arResult->current_page);?></pre>
<pre><?php print_r($arResult->faq_list);?></pre>
<pre><?php print_r($arResult->sort['sort'][array_key_first($arResult->sort['sort'])]);?></pre>
<pre><?php print_r(array_key_first($arResult->sort['sort']));?></pre>
<pre><?php print_r(get_class_methods($arResult->nav));?></pre>


<script>

	$(function () {

		$('.open_add_faq_form').click(function () {
			BX.SidePanel.Instance.open('add_faq_form.php', {
				allowChangeHistory: false,
			});
		});

		BX.addCustomEvent("SidePanel.Slider:onCloseComplete", function(event) {
			ticketsFAQGridReload();
		});

	});

	function ticketsFAQGridReload () {
		var reloadParams = { apply_filter: 'Y', clear_nav: 'Y' };
		var gridObject = BX.Main.gridManager.getById('klimsol_tickets_faq_grid');
		if (gridObject.hasOwnProperty('instance')){
			gridObject.instance.reloadTable('POST', reloadParams);
		}
	}

	function ticketsFAQDeleteItem (item_id) {
		console.clear();
		BX.ajax.runComponentAction(
			'klimsol:tickets_faq',
			'ticketsFAQDeleteItem',
			{
				mode: 'ajax',
				data: {
					item_id,
				},
			}
			).then(function (result)
			{
				console.log(result.data);
			}).then(ticketsFAQGridReload());

		}

		function ticketsFAQUpdateItem (item_id) {
			BX.SidePanel.Instance.open('add_faq_form.php?update='+item_id, {
				allowChangeHistory: false,
			});
		}


	</script>