<?php 
CModule::IncludeModule('klimsol.tickets');
/**
 * 
 */
class TicketsFAQ extends CBitrixComponent
{
	
	function updateFAQ ($update) {
		Bitrix\Klimsol\FaqTable::update($update, [
			'QUESTION' => $_POST['question'],
			'ANSWER' => $_POST['answer'],
		]);
	}

	function addFAQ () {
		Bitrix\Klimsol\FaqTable::add([
			'DATE' => time(),
			'QUESTION' => $_POST['question'],
			'ANSWER' => $_POST['answer'],
		]);
	}

	function getFAQItemById ($item_id) {
		return Bitrix\Klimsol\FaqTable::GetList([
			'filter' => [
				'ID' => $item_id,
			],
		])->Fetch();
	}

	

	function getGridFAQList () {
		
		$this->faq_list = $this->getFAQList();
		foreach ($this->faq_list as $key => $value) {
			$arr[] = [
				'data'    => [ 
					'ID' => $value['ID'],
					'DATE' => ConvertTimeStamp($value['DATE']),
					'QUESTION' => $value['QUESTION'],
					'ANSWER' => $value['ANSWER'],
				],
				'actions' => [ 
					[
						'text'    => 'Update',
						'onclick' => 'ticketsFAQUpdateItem('.$value['ID'].')',
					],
					[
						'text'    => 'Delete',
						'onclick' => 'ticketsFAQDeleteItem('.$value['ID'].')',
					]
				],
			];
		}
		return $arr;
	}

	function getFAQRowCount () {
		global $DB;
		$dbRes = $DB->Query('SELECT * FROM `ts_rates_category` WHERE ID = 10');
	}

	function getFAQList () {
		$this->grid_options = new Bitrix\Main\Grid\Options('klimsol_tickets_faq_grid');
		$this->sort = $this->grid_options->GetSorting([
			'sort' => ['ID' => 'DESC'],
			'vars' => ['by' => 'by', 'order' => 'order']
		]);
		$this->nav_params = $this->grid_options->GetNavParams();
		$this->nav = new Bitrix\Main\UI\PageNavigation('klimsol_tickets_faq_grid');
		$this->nav->allowAllRecords(true)
		->setPageSize($this->nav_params['nPageSize'])
		->initFromUri();
		$this->nav->setRecordCount(10);

		return Bitrix\Klimsol\FaqTable::GetList([
			'offset' => $this->nav->getOffset(),
			'limit' => $this->nav->getPageSize(),
			'order' => $this->grid_options->getSorting()['sort'],
			'filter' => [
			],
		])->FetchAll();
	}


}

?>