<?php 

/**
 * 
 */
class TicketsFAQ extends CBitrixComponent
{
	
	function updateFAQ ($update) {
		global $DB;
		$DB->Query('UPDATE `b_klimsol_faq` SET `QUESTION`="'.$_POST['question'].'", `ANSWER`="'.$_POST['answer'].'" WHERE `ID`='.$update);
	}

	function addFAQ () {
		global $DB;
		$DB->Query('INSERT INTO `b_klimsol_faq` (`DATE`, `QUESTION`, `ANSWER`) VALUES ('.time().',"'.$_POST['question'].'", "'.$_POST['answer'].'")');
	}

	function getFAQItemById ($item_id) {
		global $DB;
		return $DB->Query('SELECT * FROM `b_klimsol_faq` WHERE `ID`='.$item_id)->Fetch();
	}

	function setGridFAQfilter () {
		$filter = [];
		$filterOption = new Bitrix\Main\UI\Filter\Options('klimsol_tickets_faq_filter');
		$filterData = $filterOption->getFilter([]);

		foreach ($filterData as $k => $v) {
			$filter[$k] = $v;            
		}

		$search = $filterOption->getSearchString();
		$grid_filter = '';
		if ($search and !$filter['DATE_from']) {
			$grid_filter = 'WHERE `QUESTION` LIKE "%'.$search.'%" OR `ANSWER` LIKE "%'.$search.'%"';
		}

		$date_from = MakeTimeStamp($filter['DATE_from']);
		$date_to = MakeTimeStamp($filter['DATE_to']);
		if (!$search and $filter['DATE_from']) {
			$grid_filter = 'WHERE `DATE` BETWEEN '.$date_from.' AND '.$date_to;
		}

		if ($search and $filter['DATE_from']) {
			$grid_filter = 'WHERE (`QUESTION` LIKE "%'.$search.'%" OR `ANSWER` LIKE "%'.$search.'%")';
			$grid_filter = $grid_filter.' AND ';
			$grid_filter = $grid_filter.'(`DATE` BETWEEN '.$date_from.' AND '.$date_to.')';
		}

		$filter_json = [$date_from, $date_to, $search];

		file_put_contents(
			$_SERVER['DOCUMENT_ROOT'].'/test/test.json',
			json_encode($filter_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
		);
		// CUserOptions::SetOption('tickets_faq_filter', 'filter', $grid_filter, false, false);
		return $grid_filter;
	}

	function getGridFAQList () {
		$this->filter = $this->setGridFAQfilter();
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

	function getFAQList () {
		global $DB;
		$dbRes = $DB->Query('SELECT * FROM `b_klimsol_faq` 
			'.$this->filter.'
			ORDER BY `' . array_key_first($this->sort['sort']). '`
			' . $this->sort['sort'][array_key_first($this->sort['sort'])].' 
			LIMIT ' . $this->page_size . ' OFFSET ' . $this->offset);
		while ($row = $dbRes->Fetch()) {
			$arr[] = $row;
		}
		return $arr;
	}

	function getFAQCount () {
		global $DB;
		return $DB->Query('SELECT COUNT(*) FROM `b_klimsol_faq`	'.$this->filter)->Fetch()['COUNT(*)'];
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