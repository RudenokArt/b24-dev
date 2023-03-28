<?

Class deal_award extends CModule
{
  var $MODULE_ID = "deal_award";
  var $MODULE_VERSION;
  var $MODULE_VERSION_DATE;
  var $MODULE_NAME;
  var $MODULE_DESCRIPTION;
  var $MODULE_CSS;

  function __construct()
  {
    $arModuleVersion = array();

    $path = str_replace("\\", "/", __FILE__);
    $path = substr($path, 0, strlen($path) - strlen("/index.php"));
    include($path."/version.php");

    if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
    {
      $this->MODULE_VERSION = $arModuleVersion["VERSION"];
      $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
    }

    $this->MODULE_NAME = "deal_award – module with component";
    $this->MODULE_DESCRIPTION = "After installation, you will be able to use the component deal_award";
  }

  function InstallFiles()
  {
    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/deal_award/install/components",
     $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);
    return true;
  }

  function UnInstallFiles()
  {
    DeleteDirFilesEx("/local/components/art_r/deal_award/");
    return true;
  }

  function DoInstall()
  {
    global $DOCUMENT_ROOT, $APPLICATION;
    $this->InstallFiles();
    $this->InstalDealFields();
    $this->InstalDealAwardTable();
    RegisterModule("deal_award");
    $APPLICATION->IncludeAdminFile("installing the module deal_award", $DOCUMENT_ROOT."/local/modules/deal_award/install/step.php");
  }

  function DoUninstall()
  {
    global $DOCUMENT_ROOT, $APPLICATION;
    $this->UnInstallFiles();
    $this->UnInstalDealFields();
    $this->UnInstalDealAwardTable();
    UnRegisterModule("deal_award");
    $APPLICATION->IncludeAdminFile("Uninstalling the module deal_award", $DOCUMENT_ROOT."/local/modules/deal_award/install/unstep.php");
  }

  function InstalDealAwardTable () {
    $hl_create = Bitrix\Highloadblock\HighloadBlockTable::add(array(
      'NAME' => 'DealAward',
      'TABLE_NAME' => 'deal_award', 
    ));
    $hl_id = $hl_create->getId();
    $obUserField  = new CUserTypeEntity;
    $obUserField->Add([
      "ENTITY_ID" => "HLBLOCK_".$hl_id,
      "FIELD_NAME" => "UF_USER_ID",
      "USER_TYPE_ID" => "integer",
    ]);

    $obUserField->Add([
      "ENTITY_ID" => "HLBLOCK_".$hl_id,
      "FIELD_NAME" => "UF_DEAL_ID",
      "USER_TYPE_ID" => "integer",
    ]);

    $obUserField->Add([
      "ENTITY_ID" => "HLBLOCK_".$hl_id,
      "FIELD_NAME" => "UF_AWARD_TYPE",
      "USER_TYPE_ID" => "string",
    ]);

    $obUserField->Add([
      "ENTITY_ID" => "HLBLOCK_".$hl_id,
      "FIELD_NAME" => "UF_AWARD_SIZE",
      "USER_TYPE_ID" => "integer",
    ]);

    $obUserField->Add([
      "ENTITY_ID" => "HLBLOCK_".$hl_id,
      "FIELD_NAME" => "UF_AWARD_AMOUNT",
      "USER_TYPE_ID" => "integer",
    ]);
  }

  function UnInstalDealAwardTable () {
    $hl_get = \Bitrix\Highloadblock\HighloadBlockTable::getList([
      'filter'=>['TABLE_NAME' => 'deal_award',],
    ])->Fetch()['ID'];
    if ($hl_get) {
      \Bitrix\Highloadblock\HighloadBlockTable::delete($hl_get);
    }
  }

  function UnInstalDealFields () {
    $field_id = CUserTypeEntity::GetList([], [
      'ENTITY_ID' => 'CRM_DEAL',
      'FIELD_NAME' => 'UF_CRM_DEAL_AWARD_SIZE',
    ])->Fetch()['ID'];
    $delete = (new CUserTypeEntity())->Delete($field_id);

    $field_id = CUserTypeEntity::GetList([], [
      'ENTITY_ID' => 'CRM_DEAL',
      'FIELD_NAME' => 'UF_CRM_DEAL_AWARD_TYPE',
    ])->Fetch()['ID'];
    $delete = (new CUserTypeEntity())->Delete($field_id);
  }

  function InstalDealFields () {
   $field_id = (new CUserTypeEntity())->Add([
    'ENTITY_ID' => 'CRM_DEAL',
    'FIELD_NAME' => 'UF_CRM_DEAL_AWARD_SIZE',
    'USER_TYPE_ID' => 'integer',
    'EDIT_FORM_LABEL' => [
      'ru' => 'Размер премиальных',
      'en' => 'Size of award',
      'de' => 'Prämie Größe'
    ]
  ]);

   $field_id = (new CUserTypeEntity())->Add([
    'ENTITY_ID' => 'CRM_DEAL',
    'FIELD_NAME' => 'UF_CRM_DEAL_AWARD_TYPE',
    'USER_TYPE_ID' => 'enumeration',
    'EDIT_FORM_LABEL' => [
      'ru' => 'Тип премиальных',
      'en' => 'Type of award',
      'de' => 'Prämie Typ'
    ]
  ]);

   $arAddEnum['n1'] = array(
      'XML_ID' => 'abs',//xml_id
      'VALUE' => 'absolute',//значение
      'DEF' => 'N',//по умолчанию
      'SORT' => 500//сортировка
    );

   $arAddEnum['n2'] = array(
      'XML_ID' => 'per',//xml_id
      'VALUE' => 'percent',//значение
      'DEF' => 'N',//по умолчанию
      'SORT' => 500//сортировка
    );

   $arAddEnum['n3'] = array(
      'XML_ID' => 'dif',//xml_id
      'VALUE' => 'difference',//значение
      'DEF' => 'N',//по умолчанию
      'SORT' => 500//сортировка
    );
   $obEnum = new CUserFieldEnum();
   $obEnum->SetEnumValues($field_id, $arAddEnum);
 }


}
?>