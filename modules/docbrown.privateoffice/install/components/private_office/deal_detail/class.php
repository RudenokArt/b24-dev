<?php 

/**
 * 
 */
class DealDetail extends CBitrixComponent {

	function init ($deal_id) {
		$this->data['deal'] = \Bitrix\Crm\DealTable::getList([
			'filter' => ['ID' => $deal_id,],
		])->fetch();

		$this->data['status_list'] = Bitrix\Crm\StatusTable::getList([
			'filter'=>['CATEGORY_ID' => $this->data['deal']['CATEGORY_ID'],],
		])->fetchAll();
	}

	
	
}

?>