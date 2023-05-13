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
 * <li> FILE_ID string(11) mandatory
 * <li> PASSWORD string(11) mandatory
 * <li> SIGNATURE string(8) optional default 'N'
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
			new StringField(
				'FILE_ID',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateFileId'],
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
			new StringField(
				'SIGNATURE',
				[
					'default' => 'N',
					'validation' => [__CLASS__, 'validateSignature'],
					'title' => Loc::getMessage('SIGNATURE_ENTITY_SIGNATURE_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for FILE_ID field.
	 *
	 * @return array
	 */
	public static function validateFileId()
	{
		return [
			new LengthValidator(null, 11),
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
			new LengthValidator(null, 11),
		];
	}

	/**
	 * Returns validators for SIGNATURE field.
	 *
	 * @return array
	 */
	public static function validateSignature()
	{
		return [
			new LengthValidator(null, 8),
		];
	}
}