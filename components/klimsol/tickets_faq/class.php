<?php 

/**
 * 
 */
class TicketsFAQ extends CBitrixComponent
{
	

	function addFAQ () {
		global $DB;
		$DB->Query('INSERT INTO `b_klimsol_faq` (`QUESTION`, `ANSWER`) VALUES ("'.$_POST['question'].'", "'.$_POST['answer'].'")');
	}

	function getGridFAQList () {
		$this->faq_count = $this->getFAQCount();
		$this->setFAQNav();
		$this->current_page = $this->nav->getCurrentPage();
		$this->page_size = $this->nav->getPageSize();
		$this->offset = ($this->current_page - 1) * $this->page_size;
		$this->faq_list = $this->getFAQList();
		foreach ($this->faq_list as $key => $value) {
			$arr[] = [
				'data'    => [ 
					'ID' => $value['ID'],
					'DATE' => $value['DATE'],
					'QUESTION' => $value['QUESTION'],
					'ANSWER' => $value['ANSWER'],
				],
			];
		}
		return $arr;
	}

	function getFAQList () {
		global $DB;
		$dbRes = $DB->Query('SELECT * FROM `b_klimsol_faq`
			LIMIT ' . $this->page_size . ' OFFSET ' . $this->offset);
		while ($row = $dbRes->Fetch()) {
			$arr[] = $row;
		}
		return $arr;
	}

	function getFAQCount () {
		global $DB;
		return $DB->Query('SELECT COUNT(*) FROM `b_klimsol_faq`')->Fetch()['COUNT(*)'];
	}

	function setFAQNav () {
		$this->grid_options = new Bitrix\Main\Grid\Options('klimsol_tickets_faq_grid');
		$this->sort = $this->grid_options->GetSorting([
			'sort' => ['ID' => 'DESC'],
			'vars' => ['by' => 'by', 'order' => 'order']
		]);
		$this->nav_params = $this->grid_options->GetNavParams();
		$this->nav = new Bitrix\Main\UI\PageNavigation('klimsol_tickets_faq_grid');
		$this->nav->setRecordCount($this->faq_count);
		$this->nav->allowAllRecords(true)
		->setPageSize($this->nav_params['nPageSize'])
		->initFromUri();
	}


}

?>