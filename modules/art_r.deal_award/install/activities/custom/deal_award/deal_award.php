<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class CBPdeal_award extends CBPActivity {

  public function __construct($name) {
    parent::__construct($name);
    $this->arProperties = array("Title" => "", "deal_id" => "");
  }

  public function Execute () {
    $deal_id = explode('_', $this->GetDocumentId()[2])[1];

    $deal = CCrmDeal::GetList([], [
      'ID' => $deal_id,
    ], [
      'ID',
      'ASSIGNED_BY_ID',
    ])->Fetch();

    $src_prod_row = CCrmProductRow::GetList([], [
      'OWNER_ID' => $deal_id,
      'OWNER_TYPE' => 'D',
    ], false, false, [
      'ID',
      'PRODUCT_ID',
      'PRICE_NETTO',
      'QUANTITY',
    ]);
    while ($prod_row = $src_prod_row->Fetch()) {
      $poroducts_id_arr[] = $prod_row['PRODUCT_ID'];
      $deal['prod_row'][] = $prod_row;
    }
    $prod_catalog = Bitrix\Main\Config\Option::get('crm', 'default_product_catalog_id');

    foreach ($poroducts_id_arr as $key => $value) {
      $prod = CIBlockElement::GetList([], [
        'ID' => $value,
        'IBLOCK_ID' => $prod_catalog,
      ], false, false, [
        'ID',
        'IBLOCK_ID',
        'PROPERTY_UF_CRM_DEAL_AWARD_SIZE',
        'PROPERTY_UF_CRM_DEAL_AWARD_TYPE',
      ])->Fetch();
      $prod['award_type'] = CIBlockPropertyEnum::GetList([], [
        'ID' => $prod['PROPERTY_UF_CRM_DEAL_AWARD_TYPE_ENUM_ID']
      ])->Fetch()['XML_ID'];

      $deal['products'][] = $prod;
    }

    // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/test.json', json_encode($deal));

    $this->awardCalc($deal);  
  }  

  function awardCalc($deal) {
    $total = 0;
    foreach ($deal['products'] as $key => $value) {
      if ($value['PROPERTY_UF_CRM_DEAL_AWARD_SIZE_VALUE'] and $value['PROPERTY_UF_CRM_DEAL_AWARD_TYPE_VALUE']) {
        $cost =  $deal['prod_row'][$key]['PRICE_NETTO'] * $deal['prod_row'][$key]['QUANTITY'];
        if ($value['award_type'] == 'absolute') {
          $award = $value['PROPERTY_UF_CRM_DEAL_AWARD_SIZE_VALUE'] * $deal['prod_row'][$key]['QUANTITY'];
          $total = $total + $award;
        }
        if ($value['award_type'] == 'percent') {
          $award = $value['PROPERTY_UF_CRM_DEAL_AWARD_SIZE_VALUE'] / 100 * $cost;
          $total = $total + $award;
        }
        if ($value['award_type'] == 'difference') {
          $award = ($deal['prod_row'][$key]['PRICE_NETTO'] 
            - $value['PROPERTY_UF_CRM_DEAL_AWARD_SIZE_VALUE']
          ) * $deal['prod_row'][$key]['QUANTITY'];

          $total = $total + $award;
        }
      }
    }
    $deal = [
      'ID' => $deal['ID'],
      'ASSIGNED_BY_ID' => $deal['ASSIGNED_BY_ID'],
      'AWARD_AMOUNT' => $total,
    ];

    $this->awardSave($deal);
  }


  function awardSave ($deal) {

    // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/test.json', json_encode($deal));

    $hl = \Bitrix\Highloadblock\HighloadBlockTable::getList([
      'filter' => ['TABLE_NAME' => 'deal_award',],
      'select' => ['ID'],
    ])->Fetch()['ID'];

    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hl);

    $entity_data_class = $entity->getDataClass();
    $check = $entity_data_class::getList([
      'filter'=>[
        'UF_DEAL_ID' => $deal['ID'],
      ]
    ])->Fetch();

    if ($check) {
      $entity_data_class::delete($check['ID']);
    }

    $add = $entity_data_class::add([
      'UF_USER_ID' => $deal['ASSIGNED_BY_ID'],
      'UF_DEAL_ID' => $deal['ID'],
      'UF_AWARD_AMOUNT' => $deal['AWARD_AMOUNT'],
      'UF_AWARD_TIME' => time(),
    ]);

  }

  public static function GetPropertiesDialog($documentType, $activityName,
    $arWorkflowTemplate,$arWorkflowParameters, $arWorkflowVariables,
    $arCurrentValues = null, $formName = "")  {
    $runtime = CBPRuntime::GetRuntime();

    if (!is_array($arWorkflowParameters))
      $arWorkflowParameters = array();
    if (!is_array($arWorkflowVariables))
      $arWorkflowVariables = array();

    if (!is_array($arCurrentValues))
    {
      $arCurrentValues = array("deal_id" => "{{ID}}"); 

      $arCurrentActivity= &CBPWorkflowTemplateLoader::FindActivityByName(
        $arWorkflowTemplate,
        $activityName
      );
      if (is_array($arCurrentActivity["Properties"]))
        $arCurrentValues["deal_id "] =
      $arCurrentActivity["Properties"]["deal_id"];
    }
    return $runtime->ExecuteResourceFile(
      __FILE__,
      "properties_dialog.php",
      array(
        "arCurrentValues" => $arCurrentValues,
        "formName" => $formName,
      )
    );
  }

  public static function GetPropertiesDialogValues($documentType, $activityName, 
    &$arWorkflowTemplate, &$arWorkflowParameters, &$arWorkflowVariables,
    $arCurrentValues, &$arErrors) {
    $arErrors = array();

    $runtime = CBPRuntime::GetRuntime();

    if (strlen($arCurrentValues["deal_id"]) <= 0) {
      $arErrors[] = array(
        "code" => "emptyCode",
        "message" => GetMessage("MYACTIVITY_EMPTY_TEXT"),
      );
      return false;
    }

    $arProperties = array("deal_id" => $arCurrentValues["deal_id"]);

    $arCurrentActivity = &CBPWorkflowTemplateLoader::FindActivityByName(
      $arWorkflowTemplate,
      $activityName
    );
    $arCurrentActivity["Properties"] = $arProperties;

    return true;
  }
}