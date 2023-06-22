<?php 

/**
 * 
 */
class PrivateOfficeLoginForm extends CBitrixComponent {
	
	function init ($login, $password) { 

		$this->loginForm['login'] = $login;
		$this->loginForm['password'] = $password;

		$this->loginForm['contact'] = \Bitrix\Crm\ContactTable::getList([
			'filter' => [
				'UF_USER_LOGIN' => $login,
			],
			'select' => ['ID', 'UF_USER_LOGIN', 'UF_USER_PASSWORD'],
		])->fetch();

		$this->loginForm['success'] = $this->isSuccess();

		$this->loginForm['alert'] = $this->showAlert();

	}

	function isSuccess () {
		return $this->loginForm['password'] == $this->loginForm['contact']['UF_USER_PASSWORD'];
	}

	function showAlert () {
		if ($this->loginForm['success']) {
			$_SESSION['private_office']['contact'] = $this->loginForm['contact']['ID'];
			return [
				'color' => 'success',
				'text' => 'success',
			];
		} else {
			return [
				'color' => 'danger',
				'text' => GetMessage('invalid_password'),
			];
		}
	}


}


?>