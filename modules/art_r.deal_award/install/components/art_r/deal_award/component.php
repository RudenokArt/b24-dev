<? 


if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult = new DealAward();

if (isset($_POST['deal_award_pdf_button'])) {
	echo 'deal_award_pdf_button';
	exit();
}
$this->IncludeComponentTemplate();


?>

<?php 

/**
 * 
 */
class DealAward {
	
	function __construct() {

		$this->grid_options = new Bitrix\Main\Grid\Options('report_list');
		$this->sort = $this->grid_options->GetSorting([
			'sort' => ['ID' => 'DESC'],
			'vars' => ['by' => 'by', 'order' => 'order']
		]);
		$this->nav_params = $this->grid_options->GetNavParams();
		$this->nav = new Bitrix\Main\UI\PageNavigation('report_list');
		$this->nav->allowAllRecords(true)
		->setPageSize($this->nav_params['nPageSize'])
		->initFromUri();

		$this->highload = \Bitrix\Highloadblock\HighloadBlockTable::getList([
			'filter'=>['TABLE_NAME' => 'deal_award',],
		])->Fetch();

		$this->itemsList = $this->getItemsList();
		$this->grid_items_list = $this->getGridItemsList();

	}
// <a href="/company/personal/user/1/"></a>
	function getGridItemsList () {
		foreach ($this->itemsList as $key => $value) {

			$deal = CCrmDeal::GetListEx([], [
				'ID' => $value['UF_DEAL_ID'],
			]
			, false, false, [
				'ID', 'TITLE', 'CURRENCY_ID',
			])->Fetch();

			$user = CUser::GetByID($value['UF_USER_ID'])->Fetch();
			$this->users[] = $user;

			$arr[] = [
				'data'    => [ 
					"ID" => $value['ID'],
					"UF_USER_ID" => '<a href="/company/personal/user/'.$value['UF_USER_ID'].'/">'.$user['NAME'].' '.$user['LAST_NAME'].'</a>',
					"UF_DEAL_ID" =>  '<a href="/crm/deal/details/'.$value['UF_DEAL_ID'].'/">'.$deal['TITLE'].'</a>',
					"UF_AWARD_AMOUNT" => $value['UF_AWARD_AMOUNT'] .' '. $deal['CURRENCY_ID'],
					"UF_AWARD_TIME" => ConvertTimeStamp($value['UF_AWARD_TIME']),
				],
				'actions' => [
					[
						'text'  => 'Редактировать',
						'onclick' => 'document.location.href="/accountant/reports/1/edit/"'
					],
					[
						'text'    => 'Удалить',
						'onclick' => 'document.location.href="/accountant/reports/1/delete/"'
					]
				],
			];
		}
		return $arr;
	}

	function setGridFilter () {

		$filter = [];
		$filterOption = new Bitrix\Main\UI\Filter\Options('report_list');
		$filterData = $filterOption->getFilter([]);
		foreach ($filterData as $k => $v) {
			$filter[$k] = $v;            
		}

		$grid_filter = [];

		if ($filter['DATE_to']) {
			$grid_filter[] = array(
				"LOGIC" => "AND",
				array("<UF_AWARD_TIME" => MakeTimeStamp($filter['DATE_to']),),
				array(">=UF_AWARD_TIME" => MakeTimeStamp($filter['DATE_from']),),
			);
		}

		if ($filter['USER']) {
			$grid_filter['UF_USER_ID'] = explode('U', $filter['USER'])[1];
		}

		if ($filter['DEAL']) {
			$deal_src = CCrmDeal::GetListEx([], [
				'%TITLE' => $filter['DEAL'],
			], false, false, [
				'ID',
			]);
			while ($deal = $deal_src->Fetch()) {
				$deal_id_arr[] = $deal['ID'];
			}
			$grid_filter['UF_DEAL_ID'] = $deal_id_arr;
			// file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/test.json', json_encode($deal_id_arr));
		}
		file_put_contents(__DIR__.'/filter.json', json_encode($grid_filter));
		return $grid_filter;

	}

	function getItemsList () {
		
		$items = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($this->highload);
		$entity_data_class = $items->getDataClass();
		$rsData = $entity_data_class::getList([
			'filter'=> $this->setGridFilter(),
			'count_total' => true,
			'offset' => $this->nav->getOffset(),
			'limit' => $this->nav->getPageSize(),
			'order' => $this->grid_options->getSorting()['sort'],
		]);
		$this->rsData = $rsData;
		$this->nav->setRecordCount($rsData->getCount());
		$arr = [];
		foreach ($rsData as $key => $value) {
			array_push($arr, $value);
		}
		return $arr;
	}


}


?>