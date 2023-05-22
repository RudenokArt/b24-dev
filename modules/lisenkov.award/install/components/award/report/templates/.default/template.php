<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\UI\Toolbar\Facade\Toolbar;

$APPLICATION->setTitle($arResult['TITLE']);

Toolbar::deleteFavoriteStar();

foreach($arResult['BUTTONS'] as $button) {

    Toolbar::addButton($button);

}

?>

<img id="award-preview" src="<?=$arResult['JPG']?>">

<script>

	BX.ready(function () {

		BX.message({
			'PDF_AJAX_CONTROLLER': '<?=$arResult['PDF_AJAX_CONTROLLER']?>',
			'EXCEL_AJAX_CONTROLLER': '<?=$arResult['EXCEL_AJAX_CONTROLLER']?>',
			'PDF_FILE_ID': '<?=$arResult['PDF_FILE_ID']?>',
			'EXCEL_FILE_ID': '<?=$arResult['EXCEL_FILE_ID']?>',
			'PDF_FILE_NAME': '<?=$arResult['PDF_FILE_NAME']?>',
			'EXCEL_FILE_NAME': '<?=$arResult['EXCEL_FILE_NAME']?>',
			'PDF_PATH_FILE_DETAIL': '<?=$arResult['PDF_PATH_FILE_DETAIL']?>',
			'EXCEL_PATH_FILE_DETAIL': '<?=$arResult['EXCEL_PATH_FILE_DETAIL']?>'
		});

	});

</script>