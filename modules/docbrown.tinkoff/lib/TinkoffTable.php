<?php
namespace Bitrix\Docbrown;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class TinkoffTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DATE int mandatory
 * <li> OPERATION_ID string(11) mandatory
 * <li> CRM_ID string(11) mandatory
 * </ul>
 *
 * @package Bitrix\Docbrown
 **/

class TinkoffTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_docbrown_tinkoff';
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
					'title' => Loc::getMessage('TINKOFF_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'DATE',
				[
					'required' => true,
					'title' => Loc::getMessage('TINKOFF_ENTITY_DATE_FIELD')
				]
			),
			new StringField(
				'OPERATION_ID',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateOperationId'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_OPERATION_ID_FIELD')
				]
			),
			new StringField(
				'CRM_ID',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateCrmId'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_CRM_ID_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for OPERATION_ID field.
	 *
	 * @return array
	 */
	public static function validateOperationId()
	{
		return [
			new LengthValidator(null, 11),
		];
	}

	/**
	 * Returns validators for CRM_ID field.
	 *
	 * @return array
	 */
	public static function validateCrmId()
	{
		return [
			new LengthValidator(null, 11),
		];
	}
}