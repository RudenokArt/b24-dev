
<?php
#components/bitrix/example/ajax.php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Engine\Controller;

class CustomAjaxController extends Controller {

	public static function ticketsFAQDeleteItemAction($item_id) {
		// global $DB;
		// return $DB->Query('DELETE FROM `b_klimsol_faq` WHERE `ID`='.$item_id);
		CModule::IncludeModule('klimsol.tickets');
		Bitrix\Klimsol\FaqTable::delete($item_id);
	}
}