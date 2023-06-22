<?php 

/**
 * 
 */
class Contact extends CBitrixComponent {

	function init ($contact_id) {

		$this->data = \Bitrix\Crm\ContactTable::getList([
			'filter' => [
				'ID' => $contact_id
			],
			'select' => [
				'ID',
				'FULL_NAME',
				'UF_USER_LOGIN',
			],
		])->fetch();
	}
	
}

?>