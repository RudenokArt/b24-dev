<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class CBPdeal_award extends CBPActivity {

  public function __construct($name) {
    parent::__construct($name);
    $this->arProperties = array("Title" => "", "deal_id" => "");

  }

  public function Execute () {
    // [$typeName, $id] = explode('_', $this->GetDocumentId()[2]);

    // $this->test = $this->GetDocumentId();

    $src = CCrmDeal::GetList([], [
      'ID' => $this->deal_id,
    ], [
      'ID',
      'ASSIGNED_BY_ID',
      'UF_CRM_DEAL_AWARD_TYPE',
      'UF_CRM_DEAL_AWARD_SIZE',
    ]);

    if($row = $src->Fetch()){

      $src_prod = CCrmProductRow::GetList([], [
        'OWNER_ID' => $this->deal_id,
        'OWNER_TYPE' => 'D',
      ], false, false, ['PRICE', 'QUANTITY']);

      $amount = 0;
      while ($prod = $src_prod->Fetch()) {
        $amount = $amount + $prod['PRICE'] * $prod['QUANTITY'];
      }

      $row['amount'] = $amount;

      $rsEnum = CUserFieldEnum::GetList([], ['ID' => $row['UF_CRM_DEAL_AWARD_TYPE']]);
      $arEnum = $rsEnum->Fetch();
      $row['award_type'] = $arEnum['VALUE'];
    }

    $this->saveAward($row);
  }

  function saveAward ($row) {
    $hl = \Bitrix\Highloadblock\HighloadBlockTable::getList([
      'filter'=>['TABLE_NAME' => 'deal_award',],
    ])->Fetch();

    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hl);
    $entity_data_class = $entity->getDataClass();

    $rsData = $entity_data_class::getList([
      'filter'=>[
        'UF_DEAL_ID' => $row['ID'],
      ],
    ]);
    $delete = $rsData->Fetch();
    if ($delete) {
      $entity_data_class::delete($delete['ID']);
    }
    
    if (
      (
        $row['award_type'] == 'absolute'
        or
        $row['award_type'] == 'percent'
        or
        $row['award_type'] == 'difference'
      )
      and
      $row['UF_CRM_DEAL_AWARD_SIZE'] > 0
    ) {
      $result = $entity_data_class::add([
      'UF_DEAL_ID' => $row['ID'],
      'UF_USER_ID' => $row['ASSIGNED_BY_ID'],
      'UF_AWARD_TYPE' => $row['award_type'],
      'UF_AWARD_SIZE' => $row['UF_CRM_DEAL_AWARD_SIZE'],
      'UF_DEAL_AMOUNT' => $row['amount'],
    ]);
    }
    $row['test'] =$this->GetDocumentId();
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/test.json', json_encode($row));
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