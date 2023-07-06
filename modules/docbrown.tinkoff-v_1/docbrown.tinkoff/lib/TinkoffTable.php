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
 * <li> OPERATION_ID string(55) mandatory
 * <li> ACCOUNT string(55) mandatory
 * <li> AMOUNT int mandatory
 * <li> CURRENCY string(3) mandatory
 * <li> PURPOSE string(255) mandatory
 * <li> PAYER string(255) mandatory
 * <li> CRM_ID string(22) optional
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
				'ACCOUNT',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateAccount'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_ACCOUNT_FIELD')
				]
			),
			new IntegerField(
				'AMOUNT',
				[
					'required' => true,
					'title' => Loc::getMessage('TINKOFF_ENTITY_AMOUNT_FIELD')
				]
			),
			new StringField(
				'CURRENCY',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateCurrency'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_CURRENCY_FIELD')
				]
			),
			new StringField(
				'PURPOSE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validatePurpose'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PURPOSE_FIELD')
				]
			),
			new StringField(
				'PAYER',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validatePayer'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_FIELD')
				]
			),
			new StringField(
				'CRM_ID',
				[
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
			new LengthValidator(null, 55),
		];
	}

	/**
	 * Returns validators for ACCOUNT field.
	 *
	 * @return array
	 */
	public static function validateAccount()
	{
		return [
			new LengthValidator(null, 55),
		];
	}

	/**
	 * Returns validators for CURRENCY field.
	 *
	 * @return array
	 */
	public static function validateCurrency()
	{
		return [
			new LengthValidator(null, 3),
		];
	}

	/**
	 * Returns validators for PURPOSE field.
	 *
	 * @return array
	 */
	public static function validatePurpose()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for PAYER field.
	 *
	 * @return array
	 */
	public static function validatePayer()
	{
		return [
			new LengthValidator(null, 255),
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
			new LengthValidator(null, 22),
		];
	}

	public static $paymentPropsArr = [
		'UF_CRM_1597332172' => true,
		'UF_CRM_5F363984556FC' => true,
	];

	public static function setPaymentProps ($crm) {
		\Bitrix\Main\Loader::includeModule('crm');
		$arr = explode('_', $crm);
		if ($arr[0] == 'LEAD') {
			\Bitrix\Crm\LeadTable::update($arr[1], self::$paymentPropsArr);
		} elseif ($arr[0] == 'DEAL') {
			\Bitrix\Crm\DealTable::update($arr[1], self::$paymentPropsArr);
		}
		return $arr;
	}

	public static function validatedAdd(array $arFields)
	{
		try {
			return parent::add($arFields)->getId();
		} catch (\Bitrix\Main\DB\SqlQueryException $e) {
			return $e->getMessage();
		}
	}

}
