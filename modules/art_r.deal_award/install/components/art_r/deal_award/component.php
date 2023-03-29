<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$arResult = new DealAward();

$this->IncludeComponentTemplate();

?>


<?php 

/**
 * 
 */
class DealAward {
	
	function __construct() {
		$this->highload = \Bitrix\Highloadblock\HighloadBlockTable::getList([
			'filter'=>['TABLE_NAME' => 'deal_award',],
		])->Fetch();

		$this->itemsList = $this->getItemsList();
		$this->getAwardAmount();

	}

	function getAwardAmount () {
		foreach ($this->itemsList as $key => $value) {
			if ($value['UF_AWARD_TYPE'] == 'absolute') {
				$this->itemsList[$key]['AWARD_AMOUNT'] = $value['UF_AWARD_SIZE'];
			}
			if ($value['UF_AWARD_TYPE'] == 'percent') {
				$this->itemsList[$key]['AWARD_AMOUNT'] = $value['UF_DEAL_AMOUNT'] * ($value['UF_AWARD_SIZE'] + 1) / 100;
			}
			if ($value['UF_AWARD_TYPE'] == 'difference') {
				$this->itemsList[$key]['AWARD_AMOUNT'] = $value['UF_AWARD_SIZE'] - $value['UF_DEAL_AMOUNT'];
			}
		}
	}

	function getItemsList () {
		$items = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($this->highload);
		$entity_data_class = $items->getDataClass();
		$rsData = $entity_data_class::getList(['filter'=>[]]);
		$arr = [];
		foreach ($rsData as $key => $value) {
			array_push($arr, $value);
		}
		return $arr;
	}


}


?>