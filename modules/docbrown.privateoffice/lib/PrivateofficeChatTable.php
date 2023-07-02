<?php 

namespace Bitrix\Docbrown;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;

Loc::loadMessages(__FILE__);

/**
 * Class PrivateofficeChatTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DEAL int mandatory
 * <li> CONTACT int mandatory
 * <li> CHAT int mandatory
 * <li> USER int mandatory
 * </ul>
 *
 * @package Bitrix\Docbrown
 **/

class PrivateofficeChatTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_docbrown_privateoffice_chat';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('PRIVATEOFFICE_CHAT_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'DEAL',
				[
					'required' => true,
					'title' => Loc::getMessage('PRIVATEOFFICE_CHAT_ENTITY_DEAL_FIELD')
				]
			),
			new IntegerField(
				'CONTACT',
				[
					'required' => true,
					'title' => Loc::getMessage('PRIVATEOFFICE_CHAT_ENTITY_CONTACT_FIELD')
				]
			),
			new IntegerField(
				'CHAT',
				[
					'required' => true,
					'title' => Loc::getMessage('PRIVATEOFFICE_CHAT_ENTITY_CHAT_FIELD')
				]
			),
			new IntegerField(
				'USER',
				[
					'required' => true,
					'title' => Loc::getMessage('PRIVATEOFFICE_CHAT_ENTITY_USER_FIELD')
				]
			),
		];
	}
}

?>