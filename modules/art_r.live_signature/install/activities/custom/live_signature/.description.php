<?php 

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arActivityDescription = array(
    "NAME" => 'live_signature',
    "DESCRIPTION" => 'live_signature',
    "TYPE" => "activity",  // Тип - действие
    "CLASS" => "live_signature", //Класс с Activity
    "JSCLASS" => "BizProcActivity",  //Стандартная JS библиотека, которая будет рисовать Activity    
    "CATEGORY" => array(
        "ID" => "crm", // Activity будет располагаться в категории "Прочее"
    ),
);

?>