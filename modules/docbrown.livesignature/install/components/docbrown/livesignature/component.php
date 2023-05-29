<?php 
if (isset($_POST['check_generated_files'])) {
	$check_generated_pdf = file_exists($_POST['pdf']);
	$check_generated_jpg = file_exists($_POST['jpg']);
	if ($check_generated_pdf and $check_generated_jpg) {
		echo 'Y';
	} else {
		echo 'N';
	}
	exit();
}

if (isset($_POST['update_generated_files'])) {

	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::includeModule('documentgenerator');

	$pdf = CFile::makeFileArray($_POST['pdf']);
	$pdfId = Bitrix\DocumentGenerator\Model\FileTable::saveFile($pdf)->getId();

	$jpg = CFile::makeFileArray($_POST['jpg']);
	$jpgId = Bitrix\DocumentGenerator\Model\FileTable::saveFile($jpg)->getId();

	$doc = CFile::makeFileArray($_POST['doc']);
	$docId = Bitrix\DocumentGenerator\Model\FileTable::saveFile($doc)->getId();

	$update = Bitrix\DocumentGenerator\Model\DocumentTable::update($_POST['document_table'], [
		'PDF_ID' => $pdfId,
		'IMAGE_ID' => $jpgId,
		'FILE_ID' => $docId,
	]);
	echo 'success';
	exit();
}


if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
\Bitrix\Main\Loader::includeModule('documentgenerator');
\Bitrix\Main\Loader::includeModule('transformer');
CModule::includeModule('lisenkov.phpoffice');

$this->init();
$arResult = $this->data;

$arResult['alert'] = false;

if (isset($_POST['password'])) {
	if (trim($_POST['password']) == $arResult['signature_table']['PASSWORD']) {
		$_SESSION['livesignature'] = $arResult['signature_table']['ID'];
	} else {
		$arResult['alert'] = true;
	}
} 

$this->IncludeComponentTemplate();
?>