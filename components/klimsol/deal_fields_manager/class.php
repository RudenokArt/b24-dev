<?php 

CModule::IncludeModule('klimsol.tickets');
/**
 * 
 */
class DealFieldsManager extends CBitrixComponent {
	
	function getDealFieldsList () {
		$this->dealFieldsList = CCrmRestService::onRestServiceMethod([], false, new CRestServer([
			'METHOD' => 'crm.deal.fields'
		]));

		if (isset($_POST['deal_fields'])) {
			COption::SetOptionString(
				'klimsol.tickets',
				'fields_filter',
				json_encode($_POST['deal_fields']), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}
		$this->dealFieldsFilterJson = COption::GetOptionString('klimsol.tickets', 'fields_filter');
		$this->dealFieldsFilter = json_decode($this->dealFieldsFilterJson, true);

		return $this->dealFieldsList;
	}


	
}

?>