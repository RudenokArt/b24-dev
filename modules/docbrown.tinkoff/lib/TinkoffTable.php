<?php

namespace Bitrix\Docbrown;

use Bitrix\Main\Localization\Loc,
Bitrix\Main\ORM\Data\DataManager,
Bitrix\Main\ORM\Fields\IntegerField,
Bitrix\Main\ORM\Fields\StringField,
Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use CFile;

Loc::loadMessages(__FILE__);

/**
 * Class TinkoffTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> operationDate int mandatory
 * <li> operationId string(255) mandatory
 * <li> accountNumber string(255) mandatory
 * <li> bic string(16) optional
 * <li> typeOfOperation string(255) mandatory
 * <li> category string(255) optional
 * <li> trxnPostDate string(16) optional
 * <li> authorizationDate int optional
 * <li> drawDate int optional
 * <li> chargeDate int optional
 * <li> docDate int optional
 * <li> payVo string(255) optional
 * <li> vo string(255) optional
 * <li> operationAmount int optional
 * <li> operationCurrencyDigitalCode string(8) optional
 * <li> accountAmount int optional
 * <li> accountCurrencyDigitalCode string(8) optional
 * <li> rubleAmount int optional
 * <li> description string(255) optional
 * <li> payPurpose string(255) optional
 * <li> payer_acct string(32) optional
 * <li> payer_inn string(32) optional
 * <li> payer_kpp string(32) optional
 * <li> payer_name string(255) optional
 * <li> payer_bicRu string(16) optional
 * <li> payer_corAcct string(32) optional
 * <li> receiver_acct string(32) optional
 * <li> receiver_inn string(32) optional
 * <li> receiver_name string(255) optional
 * <li> receiver_bicRu string(32) optional
 * <li> receiver_corAcct string(32) optional
 * <li> counterParty_account string(32) optional
 * <li> counterParty_inn string(32) optional
 * <li> counterParty_kpp string(32) optional
 * <li> counterParty_name string(255) optional
 * <li> counterParty_bankName string(255) optional
 * <li> counterParty_bankBic string(32) optional
 * <li> counterParty_corrAccount string(32) optional
 * <li> cardNumber string(32) optional
 * <li> ucid int optional
 * <li> mcc string(8) optional
 * <li> rrn string(16) optional
 * <li> CRM_ID string(255) optional
 * <li> PDF int optional
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
				'operationDate',
				[
					'required' => true,
					'title' => Loc::getMessage('TINKOFF_ENTITY_OPERATIONDATE_FIELD')
				]
			),
			new StringField(
				'operationId',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateOperationid'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_OPERATIONID_FIELD')
				]
			),
			new StringField(
				'accountNumber',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateAccountnumber'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_ACCOUNTNUMBER_FIELD')
				]
			),
			new StringField(
				'bic',
				[
					'validation' => [__CLASS__, 'validateBic'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_BIC_FIELD')
				]
			),
			new StringField(
				'typeOfOperation',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTypeofoperation'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_TYPEOFOPERATION_FIELD')
				]
			),
			new StringField(
				'category',
				[
					'validation' => [__CLASS__, 'validateCategory'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_CATEGORY_FIELD')
				]
			),
			new StringField(
				'trxnPostDate',
				[
					'validation' => [__CLASS__, 'validateTrxnpostdate'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_TRXNPOSTDATE_FIELD')
				]
			),
			new IntegerField(
				'authorizationDate',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_AUTHORIZATIONDATE_FIELD')
				]
			),
			new IntegerField(
				'drawDate',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_DRAWDATE_FIELD')
				]
			),
			new IntegerField(
				'chargeDate',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_CHARGEDATE_FIELD')
				]
			),
			new IntegerField(
				'docDate',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_DOCDATE_FIELD')
				]
			),
			new StringField(
				'payVo',
				[
					'validation' => [__CLASS__, 'validatePayvo'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYVO_FIELD')
				]
			),
			new StringField(
				'vo',
				[
					'validation' => [__CLASS__, 'validateVo'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_VO_FIELD')
				]
			),
			new IntegerField(
				'operationAmount',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_OPERATIONAMOUNT_FIELD')
				]
			),
			new StringField(
				'operationCurrencyDigitalCode',
				[
					'validation' => [__CLASS__, 'validateOperationcurrencydigitalcode'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_OPERATIONCURRENCYDIGITALCODE_FIELD')
				]
			),
			new IntegerField(
				'accountAmount',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_ACCOUNTAMOUNT_FIELD')
				]
			),
			new StringField(
				'accountCurrencyDigitalCode',
				[
					'validation' => [__CLASS__, 'validateAccountcurrencydigitalcode'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_ACCOUNTCURRENCYDIGITALCODE_FIELD')
				]
			),
			new IntegerField(
				'rubleAmount',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_RUBLEAMOUNT_FIELD')
				]
			),
			new StringField(
				'description',
				[
					'validation' => [__CLASS__, 'validateDescription'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_DESCRIPTION_FIELD')
				]
			),
			new StringField(
				'payPurpose',
				[
					'validation' => [__CLASS__, 'validatePaypurpose'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYPURPOSE_FIELD')
				]
			),
			new StringField(
				'payer_acct',
				[
					'validation' => [__CLASS__, 'validatePayerAcct'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_ACCT_FIELD')
				]
			),
			new StringField(
				'payer_inn',
				[
					'validation' => [__CLASS__, 'validatePayerInn'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_INN_FIELD')
				]
			),
			new StringField(
				'payer_kpp',
				[
					'validation' => [__CLASS__, 'validatePayerKpp'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_KPP_FIELD')
				]
			),
			new StringField(
				'payer_name',
				[
					'validation' => [__CLASS__, 'validatePayerName'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_NAME_FIELD')
				]
			),
			new StringField(
				'payer_bicRu',
				[
					'validation' => [__CLASS__, 'validatePayerBicru'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_BICRU_FIELD')
				]
			),
			new StringField(
				'payer_corAcct',
				[
					'validation' => [__CLASS__, 'validatePayerCoracct'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_PAYER_CORACCT_FIELD')
				]
			),
			new StringField(
				'receiver_acct',
				[
					'validation' => [__CLASS__, 'validateReceiverAcct'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_RECEIVER_ACCT_FIELD')
				]
			),
			new StringField(
				'receiver_inn',
				[
					'validation' => [__CLASS__, 'validateReceiverInn'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_RECEIVER_INN_FIELD')
				]
			),
			new StringField(
				'receiver_name',
				[
					'validation' => [__CLASS__, 'validateReceiverName'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_RECEIVER_NAME_FIELD')
				]
			),
			new StringField(
				'receiver_bicRu',
				[
					'validation' => [__CLASS__, 'validateReceiverBicru'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_RECEIVER_BICRU_FIELD')
				]
			),
			new StringField(
				'receiver_corAcct',
				[
					'validation' => [__CLASS__, 'validateReceiverCoracct'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_RECEIVER_CORACCT_FIELD')
				]
			),
			new StringField(
				'counterParty_account',
				[
					'validation' => [__CLASS__, 'validateCounterpartyAccount'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_ACCOUNT_FIELD')
				]
			),
			new StringField(
				'counterParty_inn',
				[
					'validation' => [__CLASS__, 'validateCounterpartyInn'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_INN_FIELD')
				]
			),
			new StringField(
				'counterParty_kpp',
				[
					'validation' => [__CLASS__, 'validateCounterpartyKpp'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_KPP_FIELD')
				]
			),
			new StringField(
				'counterParty_name',
				[
					'validation' => [__CLASS__, 'validateCounterpartyName'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_NAME_FIELD')
				]
			),
			new StringField(
				'counterParty_bankName',
				[
					'validation' => [__CLASS__, 'validateCounterpartyBankname'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_BANKNAME_FIELD')
				]
			),
			new StringField(
				'counterParty_bankBic',
				[
					'validation' => [__CLASS__, 'validateCounterpartyBankbic'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_BANKBIC_FIELD')
				]
			),
			new StringField(
				'counterParty_corrAccount',
				[
					'validation' => [__CLASS__, 'validateCounterpartyCorraccount'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_COUNTERPARTY_CORRACCOUNT_FIELD')
				]
			),
			new StringField(
				'cardNumber',
				[
					'validation' => [__CLASS__, 'validateCardnumber'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_CARDNUMBER_FIELD')
				]
			),
			new IntegerField(
				'ucid',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_UCID_FIELD')
				]
			),
			new StringField(
				'mcc',
				[
					'validation' => [__CLASS__, 'validateMcc'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_MCC_FIELD')
				]
			),
			new StringField(
				'rrn',
				[
					'validation' => [__CLASS__, 'validateRrn'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_RRN_FIELD')
				]
			),
			new StringField(
				'CRM_ID',
				[
					'validation' => [__CLASS__, 'validateCrmId'],
					'title' => Loc::getMessage('TINKOFF_ENTITY_CRM_ID_FIELD')
				]
			),
			new IntegerField(
				'PDF',
				[
					'title' => Loc::getMessage('TINKOFF_ENTITY_PDF_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for operationId field.
	 *
	 * @return array
	 */
	public static function validateOperationid()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for accountNumber field.
	 *
	 * @return array
	 */
	public static function validateAccountnumber()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for bic field.
	 *
	 * @return array
	 */
	public static function validateBic()
	{
		return [
			new LengthValidator(null, 16),
		];
	}

	/**
	 * Returns validators for typeOfOperation field.
	 *
	 * @return array
	 */
	public static function validateTypeofoperation()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for category field.
	 *
	 * @return array
	 */
	public static function validateCategory()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for trxnPostDate field.
	 *
	 * @return array
	 */
	public static function validateTrxnpostdate()
	{
		return [
			new LengthValidator(null, 16),
		];
	}

	/**
	 * Returns validators for payVo field.
	 *
	 * @return array
	 */
	public static function validatePayvo()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for vo field.
	 *
	 * @return array
	 */
	public static function validateVo()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for operationCurrencyDigitalCode field.
	 *
	 * @return array
	 */
	public static function validateOperationcurrencydigitalcode()
	{
		return [
			new LengthValidator(null, 8),
		];
	}

	/**
	 * Returns validators for accountCurrencyDigitalCode field.
	 *
	 * @return array
	 */
	public static function validateAccountcurrencydigitalcode()
	{
		return [
			new LengthValidator(null, 8),
		];
	}

	/**
	 * Returns validators for description field.
	 *
	 * @return array
	 */
	public static function validateDescription()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for payPurpose field.
	 *
	 * @return array
	 */
	public static function validatePaypurpose()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for payer_acct field.
	 *
	 * @return array
	 */
	public static function validatePayerAcct()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for payer_inn field.
	 *
	 * @return array
	 */
	public static function validatePayerInn()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for payer_kpp field.
	 *
	 * @return array
	 */
	public static function validatePayerKpp()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for payer_name field.
	 *
	 * @return array
	 */
	public static function validatePayerName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for payer_bicRu field.
	 *
	 * @return array
	 */
	public static function validatePayerBicru()
	{
		return [
			new LengthValidator(null, 16),
		];
	}

	/**
	 * Returns validators for payer_corAcct field.
	 *
	 * @return array
	 */
	public static function validatePayerCoracct()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for receiver_acct field.
	 *
	 * @return array
	 */
	public static function validateReceiverAcct()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for receiver_inn field.
	 *
	 * @return array
	 */
	public static function validateReceiverInn()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for receiver_name field.
	 *
	 * @return array
	 */
	public static function validateReceiverName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for receiver_bicRu field.
	 *
	 * @return array
	 */
	public static function validateReceiverBicru()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for receiver_corAcct field.
	 *
	 * @return array
	 */
	public static function validateReceiverCoracct()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for counterParty_account field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyAccount()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for counterParty_inn field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyInn()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for counterParty_kpp field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyKpp()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for counterParty_name field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for counterParty_bankName field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyBankname()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for counterParty_bankBic field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyBankbic()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for counterParty_corrAccount field.
	 *
	 * @return array
	 */
	public static function validateCounterpartyCorraccount()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for cardNumber field.
	 *
	 * @return array
	 */
	public static function validateCardnumber()
	{
		return [
			new LengthValidator(null, 32),
		];
	}

	/**
	 * Returns validators for mcc field.
	 *
	 * @return array
	 */
	public static function validateMcc()
	{
		return [
			new LengthValidator(null, 8),
		];
	}

	/**
	 * Returns validators for rrn field.
	 *
	 * @return array
	 */
	public static function validateRrn()
	{
		return [
			new LengthValidator(null, 16),
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
			new LengthValidator(null, 255),
		];
	}


	// ===================== Additional Methods ==========================

	// LEAD 
	// UF_CRM_1597332172 - признак оплаты
	// UF_CRM_1597239870 - сумма оплаты 
	// UF_CRM_1597240005": "2823" - метод оплаты	

	// DEAL
	// UF_CRM_5F363984556FC - признак оплаты 
	// UF_CRM_1573037237058 - сумма оплаты
	// UF_CRM_62E14200A426C - Квитанция об оплате
	// UF_CRM_1595578581164": "2826" - метод оплаты

	static function DealPaymentAction ($filterAndSelectArr) {
		$crm = \Bitrix\Crm\DealTable::getList($filterAndSelectArr)->fetch();
		$amount = self::crmPaymentParser($crm['UF_CRM_1573037237058']);
		if ($amount['sum'] > 0) {
			\Bitrix\Crm\DealTable::update($crm['ID'], ['UF_CRM_5F363984556FC' => true,]);
		} else {
			\Bitrix\Crm\DealTable::update($crm['ID'], ['UF_CRM_5F363984556FC' => false,]);
		}
		return $crm;
	}

	static function LeadPaymentAction ($filterAndSelectArr) {
		$crm = \Bitrix\Crm\LeadTable::getList($filterAndSelectArr)->fetch();
		$amount = self::crmPaymentParser($crm['UF_CRM_1597239870']);
		if ($amount['sum'] > 0) {
			\Bitrix\Crm\LeadTable::update($crm['ID'], ['UF_CRM_1597332172' => true,]);
		} else {
			\Bitrix\Crm\LeadTable::update($crm['ID'], ['UF_CRM_1597332172' => false,]);
		}
		return $crm;
	}

	static function debugLog ($arr) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/modules/docbrown.tinkoff/log.json', json_encode($arr));
	}

	static function crmPaymentParser ($str) {
		$arr = explode('|', $str);
		return [
			'sum' => (int) $arr[0],
			'cur' => $arr[1],
		];
	}

	static function DealPaymentMethod ($tinkoff, $crm) {
		$tinkoff = self::getList(['filter' => ['ID' => $tinkoff['ID']]])->fetch();
		if ($tinkoff['CRM_ID']) {
			$update = \Bitrix\Crm\DealTable::update($crm['ID'], ['UF_CRM_1595578581164' => 2826,]);
			return true;
		}
		return false;
	}

	static function LeadPaymentMethod ($tinkoff, $crm) {
		$tinkoff = self::getList(['filter' => ['ID' => $tinkoff['ID']]])->fetch();
		if ($tinkoff['CRM_ID']) {
			$update = \Bitrix\Crm\LeadTable::update($crm['ID'], ['UF_CRM_1597240005' => 2823,]);
			return true;
		}
		return false;
	}

	static function DealPaymentBindFile ($tinkoff, $crm, $filterAndSelectArr) {
		\Bitrix\Main\Loader::includeModule('main');
		$arFile = CFile::MakeFileArray($tinkoff['PDF']);
		$crm['UF_CRM_62E14200A426C'][] = $arFile;
		\Bitrix\Crm\DealTable::update($crm['ID'], ['UF_CRM_62E14200A426C' => $crm['UF_CRM_62E14200A426C']]);
		$crm = \Bitrix\Crm\DealTable::getList($filterAndSelectArr)->fetch();
		self::update($tinkoff['ID'], ['PDF' => array_pop($crm['UF_CRM_62E14200A426C'])]);
		self::debugLog(array_pop($crm['UF_CRM_62E14200A426C']));
	}

	public static function setPaymentProps ($tinkoff) {
		$crm_id = $tinkoff['CRM_ID'];
		if (!$crm_id) {
			return 'empty';
		}
		\Bitrix\Main\Loader::includeModule('crm');
		$arr = explode('_', $crm_id);
		$filterAndSelectArr = [
			'filter' => ['ID' => $arr[1]],
			'select' => ['*', 'UF_*'],
		];
		if ($arr[0] == 'LEAD') {
			$crm = self::LeadPaymentAction($filterAndSelectArr);
			$file = self::LeadPaymentMethod($tinkoff, $crm);
		} elseif ($arr[0] == 'DEAL') {
			$crm = self::DealPaymentAction($filterAndSelectArr);
			$file = self::DealPaymentMethod($tinkoff, $crm);
			if ($file) {
				self::DealPaymentBindFile($tinkoff, $crm, $filterAndSelectArr);
			}
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
