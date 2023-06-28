<?php 

/**
 * 
 */
class Contact_profile extends CBitrixComponent {

	function init () {

		$this->data['contact_fields'] = $this->getDealFieldsArr();

		$this->data['phoneAndEaml'] = Bitrix\Crm\FieldMultiTable::getList([
			'filter' => [
				'ENTITY_ID' => 'CONTACT',
				'ELEMENT_ID' => $_SESSION['private_office']['contact'],
				'TYPE_ID' => 'PHONE',
			],
		])->fetch();

		if (isset($_POST['contact_update'])) {
			$this->contactUpdate();
		}

		if (isset($_FILES['contact_photo'])) {
			$this->photoUpload();
		}

		$this->data['contact'] = \Bitrix\Crm\ContactTable::getList([
			'filter' => ['ID' => $_SESSION['private_office']['contact'],],
			// 'filter' => ['ID' => 91,],
			'select' => [
				'ID',
				'FULL_NAME',
				'NAME',
				'LAST_NAME',
				'SECOND_NAME',
				'PHOTO',
				'ADDRESS',
				'UF_USER_LOGIN',
				'UF_USER_PASSWORD',
				'EMAIL',
				'PHONE',
			],
		])->fetch();
		
	}

	function photoUpload () {
		$file_id = CFile::SaveFile(
			array_merge($_FILES['contact_photo'], ['del' => 'N', 'MODULE_ID' => 'main', ]),
			'tmp'
		);

		$update = \Bitrix\Crm\ContactTable::update($_SESSION['private_office']['contact'], [
			'PHOTO' => $file_id,
		]);
	}

	function contactUpdate () {

		$phone = Bitrix\Crm\FieldMultiTable::getList([
			'filter' => [
				'ENTITY_ID' => 'CONTACT',
				'ELEMENT_ID' => $_POST['ID'],
				'TYPE_ID' => 'PHONE',
			],
		])->fetch();

		if ($phone) {
			Bitrix\Crm\FieldMultiTable::update($phone['ID'],[
				'VALUE' => $_POST['PHONE'],
			]);
		} else {
			Bitrix\Crm\FieldMultiTable::add([
				'ENTITY_ID' => 'CONTACT',
				'ELEMENT_ID' => $_POST['ID'],
				'TYPE_ID' => 'PHONE',
				'VALUE_TYPE' => 'WORK',
				'COMPLEX_ID' => 'PHONE_WORK',
				'VALUE' => $_POST['PHONE'],
			]);
		}

		$email = Bitrix\Crm\FieldMultiTable::getList([
			'filter' => [
				'ENTITY_ID' => 'CONTACT',
				'ELEMENT_ID' => $_POST['ID'],
				'TYPE_ID' => 'EMAIL',
			],
		])->fetch();

		if ($email) {
			Bitrix\Crm\FieldMultiTable::update($email['ID'],[
				'VALUE' => $_POST['EMAIL'],
			]);
		} else {
			Bitrix\Crm\FieldMultiTable::add([
				'ENTITY_ID' => 'CONTACT',
				'ELEMENT_ID' => $_POST['ID'],
				'TYPE_ID' => 'EMAIL',
				'VALUE_TYPE' => 'WORK',
				'COMPLEX_ID' => 'PHONE_WORK',
				'VALUE' => $_POST['EMAIL'],
			]);
		}
		
		$update = \Bitrix\Crm\ContactTable::update($_POST['ID'], [
			'FULL_NAME' => $_POST['FULL_NAME'],
			'NAME' => $_POST['NAME'],
			'LAST_NAME' => $_POST['LAST_NAME'],
			'SECOND_NAME' => $_POST['SECOND_NAME'],
			'ADDRESS' => $_POST['ADDRESS'],
			'UF_USER_LOGIN' => $_POST['UF_USER_LOGIN'],
			'UF_USER_PASSWORD' => $_POST['UF_USER_PASSWORD'],
			'HAS_PHONE' => 'Y',
			'HAS_EMAIL' => 'Y',
		]);
	}

	function getDealFieldsArr () { // все поля сделок с именами
		foreach (CCrmContact::getFieldsInfo() as $id => $field) {
			$fields[] = [
				'FIELD_NAME' => $id,
				'MAIN_USER_FIELD_LANG_EDIT_FORM_LABEL' => CCrmContact::getFieldCaption($id)
			];
		}
		$uFields = Bitrix\Main\UserFieldTable::getList([
			'select' => ['FIELD_NAME', 'LANG.EDIT_FORM_LABEL'],
			'filter' => ['ENTITY_ID' => 'CRM_CONTACT', 'LANG.LANGUAGE_ID' => LANGUAGE_ID],
			'runtime' => [
				'LANG' => [
					'data_type' => Bitrix\Main\UserFieldLangTable::getEntity(),
					'reference' => ['this.ID' => 'ref.USER_FIELD_ID']
				]
			]
		])->fetchAll();
		$arr = array_merge($fields, $uFields);
		foreach ($arr as $key => $value) {
			$list[$value['FIELD_NAME']] = $value['MAIN_USER_FIELD_LANG_EDIT_FORM_LABEL'];
		}
		return $list;
	}

	
	
}

?>