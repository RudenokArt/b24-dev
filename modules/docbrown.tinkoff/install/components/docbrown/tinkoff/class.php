<?php 

/**
 * 
 */
class TinkoffComponent extends CBitrixComponent {
	
	function init ($currency_list) {

		$this->getGridOptions();
		$this->getGridFilter();

		$this->currency_list = $currency_list;

		$this->data['operationsArr'] = \Bitrix\Docbrown\TinkoffTable::getList([
			'offset' => $this->nav->getOffset(),
			'limit' => $this->nav->getPageSize(),
			'order' => $this->grid_options->getSorting()['sort'],
			'filter' => $this->filter,
		])->fetchAll();

		$this->data['operationsList'] = $this->operationsList($this->data['operationsArr']);

	}

	function getGridFilter () {
		$filter = [];
		$grid_filter = [];
		$filterOption = new Bitrix\Main\UI\Filter\Options('tinkoff_operations_filter');
		$filterData = $filterOption->getFilter([]);

		foreach ($filterData as $k => $v) {
			$filter[$k] = $v;            
		}

		if ($filter['DATE_from']) {
			$grid_filter[] = array(
				'LOGIC' => 'AND',
				array('<=DATE' => MakeTimeStamp($filter['DATE_to']),),
				array('>=DATE' => MakeTimeStamp($filter['DATE_from']),),
			);
		}

		if ($filter['OPERATION_ID']) {
			$grid_filter['%OPERATION_ID'] = $filter['OPERATION_ID'];
		}
		if ($filter['ACCOUNT']) {
			$grid_filter['%ACCOUNT'] = $filter['ACCOUNT'];
		}

		if ($filter['CURRENCY']) {
			$grid_filter['%CURRENCY'] = $filter['CURRENCY'];
		}
		if ($filter['PURPOSE']) {
			$grid_filter['%PURPOSE'] = $filter['PURPOSE'];
		}
		if ($filter['PAYER']) {
			$grid_filter['%PAYER'] = $filter['PAYER'];
		}
		if ($filter['CRM_ID']) {
			$grid_filter['%CRM_ID'] = $filter['CRM_ID'];
		}

		// $search = $filterOption->getSearchString();
		// if ($search) {
		// 	$grid_filter[] = array(
		// 		"LOGIC" => "OR",
		// 		array("%OPERATION_ID" => $search,),
		// 		array("%ACCOUNT" => $search,),
		// 		array(">=AMOUNT" => $search,),
		// 		array("%ANSWER" => $search,),
		// 		array("%QUESTION" => $search,),
		// 		array("%ANSWER" => $search,),
		// 		array("%QUESTION" => $search,),
		// 		array("%ANSWER" => $search,),
		// 	);
		// }
		$this->filter = $grid_filter;
	}

	function getGridOptions () {
		$this->grid_options = new Bitrix\Main\Grid\Options('tinkoff_operations_list');
		$this->sort = $this->grid_options->GetSorting([
			'sort' => ['ID' => 'DESC'],
			'vars' => ['by' => 'by', 'order' => 'order'],
		]);
		$this->nav_params = $this->grid_options->GetNavParams();
		$this->nav = new Bitrix\Main\UI\PageNavigation('tinkoff_operations_list');
		$this->nav->allowAllRecords(true)
		->setPageSize($this->nav_params['nPageSize'])
		->initFromUri();
		$this->total = \Bitrix\Docbrown\TinkoffTable::getList([
			'select' => ['TOTAL'],
			'runtime' => [
				new Bitrix\Main\Entity\ExpressionField('TOTAL', 'COUNT(*)')
			]
		])->fetch()['TOTAL'];
		$this->nav->setRecordCount($this->total);
	}

	function generateCrmLink ($crm_id) {
		if ($crm_id) {
			$arr = explode('_', $crm_id);
			$str = '<a href="/crm/'.strtolower($arr[0]).'/details/'.$arr[1].'/">'.$crm_id.'</a>';
			return $str;
		} else {
			return null;
		}
		
	}

	function operationsList ($arr) {
		foreach ($arr as $key => $value) {
			$value['CURRENCY'] = $this->currency_list[$value['CURRENCY']];
			$value['DATE'] = ConvertTimeStamp($value['DATE']);
			$value['CRM_ID'] = $this->generateCrmLink($value['CRM_ID']);
			$list[] = [
				'data' => $value,
				'actions' => [
					[
						'text'  => GetMessage('LINK'),
						'onclick' => 'Tinkoff.linkCrm("'.$value['ID'].'")',
					],
					[
						'text'    => GetMessage('DETACH'),
						'onclick' => 'Tinkoff.unlinkCrm("'.$value['ID'].'")',
					]
				],
			];
		}
		return $list;
	}

}

?>