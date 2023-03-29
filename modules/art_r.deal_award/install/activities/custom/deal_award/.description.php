<?php 

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arActivityDescription = array(
    "NAME" => 'deal_award',
    "DESCRIPTION" => 'deal_award',
    "TYPE" => "activity",  // Тип - действие
    "CLASS" => "deal_award", //Класс с Activity
    "JSCLASS" => "BizProcActivity",  //Стандартная JS библиотека, которая будет рисовать Activity    
    "CATEGORY" => array(
        "ID" => "crm", // Activity будет располагаться в категории "Прочее"
    ),
);

?>