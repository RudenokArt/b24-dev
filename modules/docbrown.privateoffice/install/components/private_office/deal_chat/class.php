<?php 
use Bitrix\Docbrown\PrivateofficeChatTable;
/**
 * 38
 */
class DealChat extends CBitrixComponent {

	function init ($arParams) {
		$this->data['contact_id'] = $_SESSION['private_office']['contact'];
		$this->data['deal_id'] = $arParams['DEAL']['ID'];

		$this->data['chat'] = $this->getChat();

		if (!$this->data['chat']) {
			$add = Bitrix\Docbrown\PrivateofficeChatTable::add([
				'DEAL' => $this->data['deal_id'],
				'CONTACT' => $this->data['contact_id'],
				'CHAT' => 12345,
				'USER' => 12345,
			]);
			$this->data['chat'] = $this->getChat();
		}


		// $this->data['test'] = Bitrix\Imopenlines\Widget\User::register([
		// 		'NAME' => 'Ol-test',
		// 		'LAST_NAME' => 'Ol-test',
		// 		'LOGIN' => 'CONTACT|'.$this->data['contact'],
		// 		// 'AVATAR' => CFile::getPath($contact['PHOTO'])
		// 	])['ID'];

		// $this->data['OlUser'] = Bitrix\Imopenlines\Widget\User::get(36);

		// $chat = new \CIMChat;
		// $chatId = $chat->Add(array(
		// 	'TITLE' => 'Chat with contact '.$this->data['contact'],
		// 	'COLOR' => 'BLUE',
		// 	'TYPE' => IM_MESSAGE_CHAT,
		// 	'AUTHOR_ID' => 1,
		// 	'USERS' => [1, 36,],
		// 	'ENTITY_TYPE' => "CRM",
		// 	'ENTITY_ID' => 'CONTACT|'.$this->data['contact'],
		// ));

		// $arMes = Array(
		// 	"TO_CHAT_ID" => 88,
		// 	"FROM_USER_ID" => 36,
		// 	"MESSAGE" => 'one more message4',
		// 	"SYSTEM" => 'Y'
		// );
		// CIMChat::AddMessage($arMes);
	}

	function getChat() {
		global $arParams;
		return Bitrix\Docbrown\PrivateofficeChatTable::getList([
			'filter' => [
				'DEAL' => $this->data['deal_id'],
				'CONTACT' => $this->data['contact_id'],
			],
		])->fetch();
	}



	
	
}

?>