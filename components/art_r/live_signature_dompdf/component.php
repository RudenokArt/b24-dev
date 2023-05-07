<?php 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include_once 'vendor/autoload.php';
include_once 'dompdf/autoload.inc.php';
$arResult = $this;
$arResult->init(
	$_SERVER['SERVER_NAME'].$this->getPath().'/invoice.docx',
	$_SERVER['SERVER_NAME'].$this->getPath().'/invoice.pdf',
	$_SERVER['DOCUMENT_ROOT'].$this->getPath().'/invoice.docx',
	$_SERVER['DOCUMENT_ROOT'].$this->getPath().'/invoice.pdf',
);


if (isset($_POST['signature'])) {
  $arResult->base64ToPng($_POST['signature']);
  $arResult->saveResultDoc();
  $arResult->showPdf();
  exit();
} else {
	copy($_SERVER['DOCUMENT_ROOT'].$this->getPath().'/template.docx', $_SERVER['DOCUMENT_ROOT'].$this->getPath().'/invoice.docx');
}

$this->IncludeComponentTemplate();
?>
