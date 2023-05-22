<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\UI\Buttons;

$arResult['TITLE'] = getMessage('AWARD_REPORT_TITLE', ['#PERIOD#' => $this->getTitle()]);

$arResult['BUTTONS']['OPEN_ON_DISK'] = new Buttons\Button([
	'color' => Buttons\Color::LIGHT_BORDER,
	'icon' => Buttons\Icon::DISK,
	'text' => getMessage('AWARD_REPORT_OPEN_ON_DISK'),
	'menu' => $this->getMenuItems('OPEN_ON_DISK')
]);
$arResult['BUTTONS']['OPEN_ON_DISK']->setNoCaps();

$arResult['BUTTONS']['OPEN'] = new Buttons\Button([
	'color' => Buttons\Color::LIGHT_BORDER,
	'text' => getMessage('AWARD_REPORT_OPEN'),
	'menu' => $this->getMenuItems('OPEN')
]);
$arResult['BUTTONS']['OPEN']->addClass('ui-btn-icon-page');
$arResult['BUTTONS']['OPEN']->setNoCaps();

$arResult['BUTTONS']['DOWNLOAD'] = new Buttons\Button([
	'color' => Buttons\Color::LIGHT_BORDER,
	'text' => getMessage('AWARD_REPORT_DOWNLOAD'),
	'menu' => $this->getMenuItems('DOWNLOAD')
]);
$arResult['BUTTONS']['DOWNLOAD']->addClass('ui-btn-icon-download');
$arResult['BUTTONS']['DOWNLOAD']->setNoCaps();


$arResult['JPG'] = CFile::getPath(Bitrix\Disk\File::loadById($arParams['JPG'])->getFileId());

$arResult['PDF_AJAX_CONTROLLER'] = $this->getPdfAjaxController();
$arResult['EXCEL_AJAX_CONTROLLER'] = $this->getExcelAjaxController();

$arResult['PDF_FILE_ID'] = $this->pdfId;
$arResult['EXCEL_FILE_ID'] = $this->xlsId;

$arResult['PDF_FILE_NAME'] = $this->pdfName;
$arResult['EXCEL_FILE_NAME'] = $this->xlsName;

$arResult['PDF_PATH_FILE_DETAIL'] = $this->pdfPathFileDetail;
$arResult['EXCEL_PATH_FILE_DETAIL'] = $this->excelPathFileDetail;


$this->includeComponentTemplate();
?>