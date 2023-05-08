<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule('art_r.live_signature');

class CBPlive_signature extends CBPActivity {

  public function __construct($name) {
    parent::__construct($name);
    $this->arProperties = array("Title" => "", "doc_template" => "");
  }

  public function Execute () {
    $file_id = Bitrix\DocumentGenerator\Model\FileTable::getBFileId($this->doc_template);
    $file = CFile::GetFileArray($file_id)['SRC'];
    $deal_id = explode('_', $this->GetDocumentId()[2])[1];
    $password = $this->passwordGenerator();
    $sig_id = $this->saveSignatureData($file_id, $deal_id, $password);
    $url = $this->customerUrl($sig_id);
    $this->timeLineMessage($url, $deal_id, $password);
  }

  public function saveSignatureData($file_id, $deal_id, $password) {
    $result = Bitrix\Live\SignatureTable::add([
      'DATE' => time(),
      'FILE_ID' => $file_id,
      'DOCUMENT_ID' => $deal_id,
      'PASSWORD' => $password,
    ]);
    return $result->getId();
  }

  public function timeLineMessage ($url, $deal_id, $password) {
    $resId = \Bitrix\Crm\Timeline\CommentEntry::create([
      'TEXT' => 'URL: '.$url.PHP_EOL.'Password: '. $password,
      'SETTINGS' => [],
      'AUTHOR_ID' => 1,
      'BINDINGS' => [
        [
          'ENTITY_TYPE_ID' => CCrmOwnerType::Deal,
          'ENTITY_ID' => $deal_id,
        ]
      ],
    ]);
  }

  public function passwordGenerator(){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < 10; $i++) {
      $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
  }

  public function customerUrl ($sig_id) {
    $arr = [
      'sig_id' => $sig_id,
    ];
    $query_string = http_build_query($arr);
    $url = $_SERVER['SERVER_NAME'].'/live_signature/?'.$query_string;
    $url = '<a href="'.$url.'">'.$url.'</a>';
    return $url;
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
      $arCurrentValues = array("doc_template" => ""); 

      $arCurrentActivity= &CBPWorkflowTemplateLoader::FindActivityByName(
        $arWorkflowTemplate,
        $activityName
      );
      if (is_array($arCurrentActivity["Properties"]))
        $arCurrentValues["doc_template "] =
      $arCurrentActivity["Properties"]["doc_template"];
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

    if (strlen($arCurrentValues["doc_template"]) <= 0) {
      $arErrors[] = array(
        "code" => "emptyCode",
        "message" => GetMessage("MYACTIVITY_EMPTY_TEXT"),
      );
      return false;
    }

    $arProperties = array("doc_template" => $arCurrentValues["doc_template"]);

    $arCurrentActivity = &CBPWorkflowTemplateLoader::FindActivityByName(
      $arWorkflowTemplate,
      $activityName
    );
    $arCurrentActivity["Properties"] = $arProperties;

    return true;
  }

}