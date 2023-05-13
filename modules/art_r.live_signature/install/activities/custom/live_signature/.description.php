<?php 

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arActivityDescription = array(
    "NAME" => 'live_signature',
    "DESCRIPTION" => 'live_signature',
    "TYPE" => "activity",  // Тип - действие
    "CLASS" => "live_signature", //Класс с Activity
    "JSCLASS" => "BizProcActivity",  //Стандартная JS библиотека, которая будет рисовать Activity    
    "CATEGORY" => ["ID" => "crm",], // Activity будет располагаться в категории "crm"
    'RETURN' => [
    'LINK' => [
        'NAME' => 'Link',
        'TYPE' => Bitrix\Bizproc\FieldType::TEXT
    ],
    'PASSWORD' => [
        'NAME' => 'Password',
        'TYPE' => Bitrix\Bizproc\FieldType::TEXT
    ]
  ]
);

?>