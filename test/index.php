<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


// namespace Bitrix\Documentgenerator;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\BooleanField,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class TemplateTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ACTIVE bool ('N', 'Y') optional default 'Y'
 * <li> NAME string(255) mandatory
 * <li> CODE string(50) optional
 * <li> REGION string(50) optional
 * <li> SORT int optional default 500
 * <li> CREATE_TIME datetime mandatory
 * <li> UPDATE_TIME datetime optional
 * <li> CREATED_BY int optional
 * <li> UPDATED_BY int optional
 * <li> MODULE_ID string(50) mandatory
 * <li> FILE_ID int mandatory
 * <li> BODY_TYPE string(255) mandatory
 * <li> NUMERATOR_ID int optional
 * <li> WITH_STAMPS bool ('N', 'Y') optional default 'N'
 * <li> IS_DELETED bool ('N', 'Y') optional default 'N'
 * </ul>
 *
 * @package Bitrix\Documentgenerator
 **/

class TemplateTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_documentgenerator_template';
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
					'title' => Loc::getMessage('TEMPLATE_ENTITY_ID_FIELD')
				]
			),
			new BooleanField(
				'ACTIVE',
				[
					'values' => array('N', 'Y'),
					'default' => 'Y',
					'title' => Loc::getMessage('TEMPLATE_ENTITY_ACTIVE_FIELD')
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('TEMPLATE_ENTITY_NAME_FIELD')
				]
			),
			new StringField(
				'CODE',
				[
					'validation' => [__CLASS__, 'validateCode'],
					'title' => Loc::getMessage('TEMPLATE_ENTITY_CODE_FIELD')
				]
			),
			new StringField(
				'REGION',
				[
					'validation' => [__CLASS__, 'validateRegion'],
					'title' => Loc::getMessage('TEMPLATE_ENTITY_REGION_FIELD')
				]
			),
			new IntegerField(
				'SORT',
				[
					'default' => 500,
					'title' => Loc::getMessage('TEMPLATE_ENTITY_SORT_FIELD')
				]
			),
			new DatetimeField(
				'CREATE_TIME',
				[
					'required' => true,
					'title' => Loc::getMessage('TEMPLATE_ENTITY_CREATE_TIME_FIELD')
				]
			),
			new DatetimeField(
				'UPDATE_TIME',
				[
					'title' => Loc::getMessage('TEMPLATE_ENTITY_UPDATE_TIME_FIELD')
				]
			),
			new IntegerField(
				'CREATED_BY',
				[
					'title' => Loc::getMessage('TEMPLATE_ENTITY_CREATED_BY_FIELD')
				]
			),
			new IntegerField(
				'UPDATED_BY',
				[
					'title' => Loc::getMessage('TEMPLATE_ENTITY_UPDATED_BY_FIELD')
				]
			),
			new StringField(
				'MODULE_ID',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateModuleId'],
					'title' => Loc::getMessage('TEMPLATE_ENTITY_MODULE_ID_FIELD')
				]
			),
			new IntegerField(
				'FILE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('TEMPLATE_ENTITY_FILE_ID_FIELD')
				]
			),
			new StringField(
				'BODY_TYPE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateBodyType'],
					'title' => Loc::getMessage('TEMPLATE_ENTITY_BODY_TYPE_FIELD')
				]
			),
			new IntegerField(
				'NUMERATOR_ID',
				[
					'title' => Loc::getMessage('TEMPLATE_ENTITY_NUMERATOR_ID_FIELD')
				]
			),
			new BooleanField(
				'WITH_STAMPS',
				[
					'values' => array('N', 'Y'),
					'default' => 'N',
					'title' => Loc::getMessage('TEMPLATE_ENTITY_WITH_STAMPS_FIELD')
				]
			),
			new BooleanField(
				'IS_DELETED',
				[
					'values' => array('N', 'Y'),
					'default' => 'N',
					'title' => Loc::getMessage('TEMPLATE_ENTITY_IS_DELETED_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for CODE field.
	 *
	 * @return array
	 */
	public static function validateCode()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for REGION field.
	 *
	 * @return array
	 */
	public static function validateRegion()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for MODULE_ID field.
	 *
	 * @return array
	 */
	public static function validateModuleId()
	{
		return [
			new LengthValidator(null, 50),
		];
	}

	/**
	 * Returns validators for BODY_TYPE field.
	 *
	 * @return array
	 */
	public static function validateBodyType()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}



include_once 'TemplateTable.php';

$arr = TemplateTable::getList()->fetchAll();


?>

<pre><?php print_r($arr); ?></pre>