<?php 

/**
 * 
 */
class DealsList extends CBitrixComponent {

	function init ($contact_id) {
		$this->data['categories_list'] = Bitrix\Crm\Category\DealCategory::getAll(true);
		$this->data['categories_arr'] = $this->getCategoriesArr();
		$this->data['deals_list'] = \Bitrix\Crm\DealTable::getList([
			'filter' => ['CONTACT_ID' => $contact_id,],
			'order' => ['ID'=>'DESC'],
			'select' => [
				'ID',
				'DATE_CREATE',
				'TITLE',
				'CATEGORY_ID',
				'STAGE_ID',
				'CLOSED',
				'CURRENCY_ID',
				'OPPORTUNITY',
			],
		])->fetchAll();

		$this->data['deals_arr'] = $this->getDealsArr();
	}

	function getDealsArr () {
		foreach ($this->data['deals_list'] as $key => $value) {
			$value['category'] = $this->data['categories_arr'][$value['CATEGORY_ID']];
			$arr[] = $value;
		}
		return $arr;
	}

	function getCategoriesArr () {
		foreach ($this->data['categories_list'] as $key => $value) {
			$arr[$value['ID']] = [
				'ID' => $value['ID'],
				'NAME' => $value['NAME'],
				'stages_list' => $this->getStagesArr($value['ID']),
			];
		}
		return $arr;
	}

	function getStagesArr ($categoryId) {
		$list = Bitrix\Crm\StatusTable::getList([
			'filter' => ['CATEGORY_ID' => $categoryId,],
			'select' => ['STATUS_ID', 'NAME', 'COLOR'], 
			'order' => ['SORT' => 'ASC'],
		])->fetchAll();
		foreach ($list as $key => $value) {
			$arr[$value['STATUS_ID']] = [
				'NAME' => $value['NAME'],
				'COLOR' => $value['COLOR'],
			];
		}
		return $arr;
	}
	
}

?>