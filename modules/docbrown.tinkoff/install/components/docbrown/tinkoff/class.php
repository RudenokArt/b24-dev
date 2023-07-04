<?php 

/**
 * 
 */
class TinkoffComponent extends CBitrixComponent {
	
	function init ($currency_list) {

		$this->currency_list = $currency_list;
		$this->getGridFieldsList(\Bitrix\Docbrown\TinkoffTable::getList()->fetch());
		$this->getGridOptions();
		$this->getGridFilter();

		$this->data['operationsArr'] = \Bitrix\Docbrown\TinkoffTable::getList([
			'offset' => $this->nav->getOffset(),
			'limit' => $this->nav->getPageSize(),
			'order' => $this->grid_options->getSorting()['sort'],
			'filter' => $this->filter,
		])->fetchAll();

		$this->data['operationsList'] = $this->operationsList($this->data['operationsArr']);
	}

	function getGridFieldsList ($operation) {

		foreach ($operation as $key => $value) {

			if (GetMessage($key)) {
				$fieldname = GetMessage($key);
			} else {
				$fieldname = $key;
			}

			$this->data['gridFieldsList'][] = [
				'id' => $key,
				'name' => $fieldname,
				'sort' => $key,
				'default' => true,
			];

			if ($key == 'operationDate') {
				$this->data['filterFieldsList'][] = [
					'id' => $key,
					'name' =>  $fieldname,
					'type' =>  'date',
					'default' => true,
				];
			} elseif ($key == 'operationCurrencyDigitalCode' or $key == 'accountCurrencyDigitalCode') {
				$this->data['filterFieldsList'][] = [
					'id' => $key,
					'name' =>  $fieldname,
					'type' => 'list',
					'items' => $this->currency_list,
					'default' => true,
				];
			} elseif (
				$key == 'trxnPostDate'
				or
				$key == 'authorizationDate'
				or
				$key == 'drawDate'
				or
				$key == 'chargeDate'
				or
				$key == 'docDate'
			) {} else {
				$this->data['filterFieldsList'][] = [
					'id' => $key,
					'name' =>  $fieldname,
					'type' => 'string',
					'default' => true,
				];
			}
		}
	}

	function getGridFilter () {
		$filter = [];
		$grid_filter = [];
		$filterOption = new Bitrix\Main\UI\Filter\Options('tinkoff_operations_filter');
		$filterData = $filterOption->getFilter([]);

		foreach ($filterData as $k => $v) {
			$filter[$k] = $v;            
		}

		if ($filter['operationDate_from']) {
			$grid_filter[] = array(
				'LOGIC' => 'AND',
				array('<=operationDate' => MakeTimeStamp($filter['operationDate_to']),),
				array('>=operationDate' => MakeTimeStamp($filter['operationDate_from']),),
			);
		}

		foreach ($this->data['filterFieldsList'] as $key => $value) {
			if ($filter[$value['id']] and $filter[$value['id']] != 'operationDate') {
				$grid_filter['%'.$value['id']] = $filter[$value['id']];
			}
		}

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
			$value['operationCurrencyDigitalCode'] = $this->currency_list[$value['operationCurrencyDigitalCode']];
			$value['operationDate'] = ConvertTimeStamp($value['operationDate'], 'FULL');
			$value['trxnPostDate'] = ConvertTimeStamp($value['trxnPostDate'], 'FULL');
			$value['authorizationDate'] = ConvertTimeStamp($value['authorizationDate'], 'FULL');
			$value['drawDate'] = ConvertTimeStamp($value['drawDate'], 'FULL');
			$value['chargeDate'] = ConvertTimeStamp($value['chargeDate'], 'FULL');
			$value['docDate'] = ConvertTimeStamp($value['operationDate'], 'FULL');
			$value['operationDate'] = ConvertTimeStamp($value['docDate'], 'FULL');
			$value['CRM_ID'] = $this->generateCrmLink($value['CRM_ID']);
			$value['PDF'] = '<a href="'.CFile::GetFileArray($value['PDF'])['SRC'].'" download>'.$value['PDF'].'</a>';
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