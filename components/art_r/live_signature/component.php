<?php 

if (isset($_POST['pdf_update'])) {
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::includeModule('documentgenerator');

	$pdf = CFile::makeFileArray($_POST['pdf_result']);
	$pdfId = Bitrix\DocumentGenerator\Model\FileTable::saveFile($pdf)->getId();

	$jpg = CFile::makeFileArray($_POST['jpg_result']);
	$jpgId = Bitrix\DocumentGenerator\Model\FileTable::saveFile($jpg)->getId();

	$docx = CFile::makeFileArray($_POST['docx_result']);
	$docxId = Bitrix\DocumentGenerator\Model\FileTable::saveFile($docx)->getId();

	Bitrix\DocumentGenerator\Model\DocumentTable::update($_POST['pdf_update'], [
		'PDF_ID' => $pdfId,
		'IMAGE_ID' => $jpgId,
		'FILE_ID' => $docxId,
	]);
	exit();
}

if (isset($_POST['pdf_for_iframe'])) {
	if (file_exists($_POST['pdf_for_iframe']) and file_exists($_POST['jpg_result'])) {
		echo true;
	} else {
		echo false;
	}
	exit();
}

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::includeModule('lisenkov.phpoffice');
CModule::IncludeModule('art_r.live_signature');
\Bitrix\Main\Loader::includeModule('documentgenerator');

$this->init();

$arResult = $this->live_signature;

$arResult['alert'] = false;

if (isset($_POST['password'])) {
	if ($_POST['password'] == $arResult['signature']['PASSWORD']) {
		$_SESSION['live_signature'] = $arResult['signature']['ID'];
	} else {
		$arResult['alert'] = true;
	}
} 

$this->IncludeComponentTemplate();
?>

