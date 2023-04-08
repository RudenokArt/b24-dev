<?
use Bitrix\Main\Loader;
Loader::IncludeModule('highloadblock');

Class art_r_deal_award extends CModule
{
  var $MODULE_ID = "art_r.deal_award";
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
    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/art_r.deal_award/install/components",
     $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);
    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/art_r.deal_award/install/activities/custom",
     $_SERVER["DOCUMENT_ROOT"]."/local/activities/custom", true, true);
    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/art_r.deal_award/install/deal_award",
     $_SERVER["DOCUMENT_ROOT"]."/deal_award", true, true);
    return true;
  }

  function UnInstallFiles()
  {
    DeleteDirFilesEx("/local/components/art_r/deal_award/");
    DeleteDirFilesEx("/local/activities/custom/deal_award/");
    DeleteDirFilesEx("/deal_award/");
    return true;
  }

  function DoInstall()
  {
    global $DOCUMENT_ROOT, $APPLICATION;
    $this->InstallFiles();
    $this->InstallProductFields();
    $this->InstalDealAwardTable();
    $this->InstalMenuItem();
    RegisterModule($this->MODULE_ID);
    $APPLICATION->IncludeAdminFile("installing the module deal_award", $DOCUMENT_ROOT."/local/modules/art_r.deal_award/install/step.php");
  }

  function DoUninstall()
  {
    global $DOCUMENT_ROOT, $APPLICATION;
    $this->UnInstallFiles();
    $this->UnInstallProductFields();
    $this->UnInstalDealAwardTable();
    $this->UnInstalMenuItem();
    UnRegisterModule($this->MODULE_ID);
    $APPLICATION->IncludeAdminFile("Uninstalling the module deal_award", $DOCUMENT_ROOT."/local/modules/art_r.deal_award/install/unstep.php");
  }

  function UnInstalMenuItem () {
    $menu_items_arr = unserialize(COption::GetOptionString('intranet', 'left_menu_custom_preset_items'));
    unset($menu_items_arr[$this->MODULE_ID]);
    COption::SetOptionString('intranet', 'left_menu_custom_preset_items', serialize($menu_items_arr));
  }

  function InstalMenuItem () {
    COption::SetOptionString('intranet', 'left_menu_preset', 'custom');
    $menu_items_arr = unserialize(COption::GetOptionString('intranet', 'left_menu_custom_preset_items'));
    $menu_items_arr[$this->MODULE_ID] = ['LINK' => '/deal_award/', 'TEXT' => GetMessage('deal_award')];
    COption::SetOptionString('intranet', 'left_menu_custom_preset_items', serialize($menu_items_arr));
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
      "FIELD_NAME" => "UF_AWARD_AMOUNT",
      "USER_TYPE_ID" => "integer",
    ]);
    $obUserField->Add([
      "ENTITY_ID" => "HLBLOCK_".$hl_id,
      "FIELD_NAME" => "UF_AWARD_TIME",
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

  function UnInstallProductFields () {
   $option1 = CIBlockPropertyEnum::GetList([], [
    'VALUE' => 'absolute',
  ])->Fetch();
   $delete1 = CIBlockPropertyEnum::Delete($option1['ID']);

   $option2 = CIBlockPropertyEnum::GetList([], [
    'VALUE' => 'percent',
  ])->Fetch();
   $delete2 = CIBlockPropertyEnum::Delete($option2['ID']);

   $option3 = CIBlockPropertyEnum::GetList([], [
    'VALUE' => 'difference',
  ])->Fetch();
   $delete3 = CIBlockPropertyEnum::Delete($option3['ID']);

   $p_size = CIBlockProperty::GetList([
    'CODE' => 'UF_CRM_DEAL_AWARD_SIZE'
  ])->Fetch();
   $delete_size = CIBlockProperty::Delete($p_size['ID']);

   $p_type = CIBlockProperty::GetList([
    'CODE' => 'UF_CRM_DEAL_AWARD_TYPE'
  ])->Fetch();
   $delete_type = CIBlockProperty::Delete($p_type['ID']);
 }

 function InstallProductFields () {

  $iblock_id = Bitrix\Main\Config\Option::get('crm', 'default_product_catalog_id');

  $p_size = (new CIBlockProperty)->Add([
    'NAME' => GetMessage('deal_award_size'),
    'ACTIVE' => 'Y',
    'SORT' => 500,
    'CODE' => 'UF_CRM_DEAL_AWARD_SIZE',
    'PROPERTY_TYPE' => 'N',
    'IBLOCK_ID' => $iblock_id,
  ]);

  $p_type = (new CIBlockProperty)->Add([
    'NAME' => GetMessage('deal_award_type'),
    'ACTIVE' => 'Y',
    'SORT' => 500,
    'CODE' => 'UF_CRM_DEAL_AWARD_TYPE',
    'PROPERTY_TYPE' => 'L',
    'IBLOCK_ID' => $iblock_id,
  ]);
  $option1 = (new CIBlockPropertyEnum)->Add([
    'PROPERTY_ID' => $p_type,
    'VALUE' => GetMessage('absolute'),
    'EXTERNAL_ID' => 'absolute',
  ]);
  $option2 = (new CIBlockPropertyEnum)->Add([
    'PROPERTY_ID' => $p_type,
    'VALUE' => GetMessage('percent'),
    'EXTERNAL_ID' => 'percent',
  ]);
  $option3 = (new CIBlockPropertyEnum)->Add([
    'PROPERTY_ID' => $p_type,
    'VALUE' => GetMessage('difference'),
    'EXTERNAL_ID' => 'difference',
  ]);
}

}
?>