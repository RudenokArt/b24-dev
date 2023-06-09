<?php 
$APPLICATION->SetTitle(GetMessage('add_question'));
\Bitrix\Main\UI\Extension::load("ui.forms"); 
\Bitrix\Main\Loader::includeModule('fileman');
\Bitrix\Main\UI\Extension::load("ui.hint");
\Bitrix\Main\UI\Extension::load("ui.dialogs.messagebox");
\CJSCore::init("sidepanel");
CJSCore::Init(array("jquery"));
use Bitrix\UI\Toolbar\Facade\Toolbar;
Toolbar::DeleteFavoriteStar();

if (isset($_POST['ticket_faq_add']) and $_POST['ticket_faq_add'] == 'Y') {
	if (isset($_GET['update'])) {
	$arResult->updateFAQ($_GET['update']);
	} else {
		$arResult->addFAQ();
	}
	?><script>window.top.ticketsFAQGridReload();</script><?
}

if (isset($_GET['update'])) {
	$ticket_faq_update_item = $arResult->getFAQItemById($_GET['update']);
	$APPLICATION->SetTitle(GetMessage('update_question'));
}


?>



<form action="" method="post" id="ticket_faq_add_form">
	<b>*<?php echo GetMessage('question'); ?>:</b>
	<?php 
	$LHE = new CHTMLEditor;
	$LHE->Show(
		array(
			'name' => 'question',
			'id' => 'question',
			'inputName' => 'question',
			'content' => $ticket_faq_update_item['QUESTION'],
			'width' => '100%',
			'minBodyWidth' => 230,
			'normalBodyWidth' => 555,
			'height' => '200',
			'bAllowPhp' => false,
			'limitPhpAccess' => false,
			'autoResize' => true,
			'autoResizeOffset' => 40,
			'setFocusAfterShow' => false,
			'useFileDialogs' => false,
			'saveOnBlur' => true,
			'showTaskbars' => false,
			'showNodeNavi' => false,
			'askBeforeUnloadPage' => true,
			'bbCode' => false,
			'siteId' => SITE_ID,
			'controlsMap' => array(
				array(
					'id' => 'Bold',
					'compact' => true,
					'sort' => 80
				),
				array(
					'id' => 'Italic',
					'compact' => true,
					'sort' => 90
				),
				array(
					'id' => 'Underline',
					'compact' => true,
					'sort' => 100
				),
				array(
					'id' => 'Strikeout',
					'compact' => true,
					'sort' => 110
				),
				array(
					'id' => 'RemoveFormat',
					'compact' => true,
					'sort' => 120
				),
				array(
					'id' => 'Color',
					'compact' => true,
					'sort' => 130
				),
				array(
					'id' => 'FontSelector',
					'compact' => false,
					'sort' => 135
				),
				array(
					'id' => 'FontSize',
					'compact' => false,
					'sort' => 140
				),
				array(
					'separator' => true,
					'compact' => false,
					'sort' => 145
				),
				array(
					'id' => 'OrderedList',
					'compact' => true,
					'sort' => 150
				),
				array(
					'id' => 'UnorderedList',
					'compact' => true,
					'sort' => 160
				),
				array(
					'id' => 'AlignList',
					'compact' => false,
					'sort' => 190
				),
				array(
					'separator' => true,
					'compact' => false,
					'sort' => 200
				),
				array(
					'id' => 'InsertLink',
					'compact' => true,
					'sort' => 210
				),
				array(
					'id' => 'InsertTable',
					'compact' => false,
					'sort' => 250
				),
				array(
					'separator' => true,
					'compact' => false,
					'sort' => 290
				),
				array(
					'id' => 'Fullscreen',
					'compact' => false,
					'sort' => 310
				),
				array(
					'id' => 'More',
					'compact' => true,
					'sort' => 400
				)
			)
		)
	);
	?>
	<br>
	<b>*<?php echo GetMessage('answer'); ?>:</b>
	<?php 
	$LHE = new CHTMLEditor;
	$LHE->Show(
		array(
			'name' => 'answer',
			'id' => 'answer',
			'inputName' => 'answer',
			'content' => $ticket_faq_update_item['ANSWER'],
			'width' => '100%',
			'minBodyWidth' => 230,
			'normalBodyWidth' => 555,
			'height' => '200',
			'bAllowPhp' => false,
			'limitPhpAccess' => false,
			'autoResize' => true,
			'autoResizeOffset' => 40,
			'setFocusAfterShow' => false,
			'useFileDialogs' => false,
			'saveOnBlur' => true,
			'showTaskbars' => false,
			'showNodeNavi' => false,
			'askBeforeUnloadPage' => true,
			'bbCode' => false,
			'siteId' => SITE_ID,
			'controlsMap' => array(
				array(
					'id' => 'Bold',
					'compact' => true,
					'sort' => 80
				),
				array(
					'id' => 'Italic',
					'compact' => true,
					'sort' => 90
				),
				array(
					'id' => 'Underline',
					'compact' => true,
					'sort' => 100
				),
				array(
					'id' => 'Strikeout',
					'compact' => true,
					'sort' => 110
				),
				array(
					'id' => 'RemoveFormat',
					'compact' => true,
					'sort' => 120
				),
				array(
					'id' => 'Color',
					'compact' => true,
					'sort' => 130
				),
				array(
					'id' => 'FontSelector',
					'compact' => false,
					'sort' => 135
				),
				array(
					'id' => 'FontSize',
					'compact' => false,
					'sort' => 140
				),
				array(
					'separator' => true,
					'compact' => false,
					'sort' => 145
				),
				array(
					'id' => 'OrderedList',
					'compact' => true,
					'sort' => 150
				),
				array(
					'id' => 'UnorderedList',
					'compact' => true,
					'sort' => 160
				),
				array(
					'id' => 'AlignList',
					'compact' => false,
					'sort' => 190
				),
				array(
					'separator' => true,
					'compact' => false,
					'sort' => 200
				),
				array(
					'id' => 'InsertLink',
					'compact' => true,
					'sort' => 210
				),
				array(
					'id' => 'InsertTable',
					'compact' => false,
					'sort' => 250
				),
				array(
					'separator' => true,
					'compact' => false,
					'sort' => 290
				),
				array(
					'id' => 'Fullscreen',
					'compact' => false,
					'sort' => 310
				),
				array(
					'id' => 'More',
					'compact' => true,
					'sort' => 400
				)
			)
		)
	);
	?>
	<button id="ticket_faq_submit_button" name="ticket_faq_add" value="Y" style="opacity: 0;"></button>
</form>

<?$APPLICATION->IncludeComponent('bitrix:ui.button.panel', '', [
    'BUTTONS' => [
		[
			'TYPE' => 'custom',
			'LAYOUT' => '<div id="task-save" class="ticket_faq_save_button ui-btn ui-btn-success ui-btn-icon-done">save</div>'
		],
		['TYPE' => 'cancel', 'CAPTION' => 'cancel']
	]
]);?>

<script>
	$(function () {
		$('#question').attr('required', 'required');
		$('.ticket_faq_save_button').click(function () {
			var question = $('input[name="question"]').prop('value');
			var answer = $('input[name="answer"]').prop('value');
			if (!answer || !question) {
				BX.UI.Dialogs.MessageBox.alert("<?php echo GetMessage('required'); ?>");
			} else {
				document.getElementById('ticket_faq_submit_button').click();
				BX.SidePanel.Instance.closeAll([immediately=false]);
			}
		});
	});
	
</script>

