<?php
namespace Bitrix\Klimsol;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator,
	Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

/**
 * Class FaqTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DATE datetime optional default current datetime
 * <li> QUESTION string(500) mandatory
 * <li> ANSWER string(500) mandatory
 * </ul>
 *
 * @package Bitrix\Klimsol
 **/

class FaqTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_klimsol_faq';
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
					'title' => Loc::getMessage('FAQ_ENTITY_ID_FIELD')
				]
			),
			new DatetimeField(
				'DATE',
				[
					'default' => function()
					{
						return new DateTime();
					},
					'title' => Loc::getMessage('FAQ_ENTITY_DATE_FIELD')
				]
			),
			new StringField(
				'QUESTION',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateQuestion'],
					'title' => Loc::getMessage('FAQ_ENTITY_QUESTION_FIELD')
				]
			),
			new StringField(
				'ANSWER',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateAnswer'],
					'title' => Loc::getMessage('FAQ_ENTITY_ANSWER_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for QUESTION field.
	 *
	 * @return array
	 */
	public static function validateQuestion()
	{
		return [
			new LengthValidator(null, 500),
		];
	}

	/**
	 * Returns validators for ANSWER field.
	 *
	 * @return array
	 */
	public static function validateAnswer()
	{
		return [
			new LengthValidator(null, 500),
		];
	}
}