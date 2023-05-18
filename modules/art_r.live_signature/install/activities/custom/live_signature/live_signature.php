<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule('art_r.live_signature');

class CBPlive_signature extends CBPActivity {

  public function __construct($name) {
    parent::__construct($name);
    $this->arProperties = array("Title" => "", "doc_id" => "");
  }

  public function Execute () {
    $this->arProperties['PASSWORD'] = randString(7);
    $live_signature_id = Bitrix\Live\SignatureTable::add([
      'DATE' => time(),
      'FILE_ID' => $this->doc_id,
      'PASSWORD' => $this->arProperties['PASSWORD'],
    ]);
    $this->arProperties['LINK'] = 'https://' . $_SERVER['SERVER_NAME'].
    '/live_signature/?id='.$live_signature_id->getId();
    // file_put_contents(
    //   $_SERVER['DOCUMENT_ROOT'].'/test/test.json',
    //   json_encode(get_class_methods($live_signature_id->getId()))
    // );
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
      $arCurrentValues = [
        'doc_id' => $arCurrentActivity['Properties']['doc_id']
      ]; 

      $arCurrentActivity= &CBPWorkflowTemplateLoader::FindActivityByName(
        $arWorkflowTemplate,
        $activityName
      );
      if (is_array($arCurrentActivity["Properties"]))
        $arCurrentValues["doc_id"] =
      $arCurrentActivity["Properties"]["doc_id"];
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

    if (strlen($arCurrentValues["doc_id"]) <= 0) {
      $arErrors[] = array(
        "code" => "emptyCode",
        "message" => GetMessage('document_id').' - '.GetMessage('required'),
      );
      return false;
    }

    $arProperties = [
      'doc_id' => $arCurrentValues['doc_id'],
    ];

    $arProperties = array("doc_id" => $arCurrentValues["doc_id"]);

    $arCurrentActivity = &CBPWorkflowTemplateLoader::FindActivityByName(
      $arWorkflowTemplate,
      $activityName
    );
    $arCurrentActivity["Properties"] = $arProperties;

    return true;
  }
}