<?php
namespace Bitrix\Live;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class SignatureTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DATE int mandatory
 * <li> DOCUMENT_ID int mandatory
 * <li> FILE_ID int mandatory
 * <li> PASSWORD string(16) mandatory
 * <li> SIGN int optional
 * </ul>
 *
 * @package Bitrix\Live
 **/

class SignatureTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_live_signature';
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
					'title' => Loc::getMessage('SIGNATURE_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'DATE',
				[
					'required' => true,
					'title' => Loc::getMessage('SIGNATURE_ENTITY_DATE_FIELD')
				]
			),
			new IntegerField(
				'DOCUMENT_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('SIGNATURE_ENTITY_DOCUMENT_ID_FIELD')
				]
			),
			new IntegerField(
				'FILE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('SIGNATURE_ENTITY_FILE_ID_FIELD')
				]
			),
			new StringField(
				'PASSWORD',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validatePassword'],
					'title' => Loc::getMessage('SIGNATURE_ENTITY_PASSWORD_FIELD')
				]
			),
			new IntegerField(
				'SIGN',
				[
					'title' => Loc::getMessage('SIGNATURE_ENTITY_SIGN_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for PASSWORD field.
	 *
	 * @return array
	 */
	public static function validatePassword()
	{
		return [
			new LengthValidator(null, 16),
		];
	}
}