<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");

use Bitrix\UI\Toolbar\Facade\Toolbar;
CJSCore::Init(array("jquery"));

Toolbar::AddFilter([ 
  'FILTER_ID' => 'report_list', 
  'GRID_ID' => 'report_list', 
  'FILTER' => [ 
    ['id' => 'DATE', 'name' => 'date', 'type' => 'date'],
    ['id' => 'DEAL', 'name' => 'deal', 'type' => 'string'],
    ['id' => 'USER', 'name' => 'user', 'type' => 'dest_selector'],
  ],
  'ENABLE_LIVE_SEARCH' => true, 
  'ENABLE_LABEL' => true
]);

$deal_award_pdf_button = new \Bitrix\UI\Buttons\Button([
  'icon' => Bitrix\UI\Buttons\Icon::PRINT,
  'text' => 'pdf',
]);
Toolbar::addButton($deal_award_pdf_button);

$deal_award_pdf_button->addClass('deal_award_pdf_button');


$APPLICATION->IncludeComponent(
  'bitrix:main.ui.grid',
  '',
  [
    'GRID_ID' => 'report_list', 
    'COLUMNS' => [
      ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true], 
      ['id' => 'UF_USER_ID', 'name' => GetMessage('user'), 'sort' => 'UF_USER_ID', 'default' => true], 
      ['id' => 'UF_DEAL_ID', 'name' => GetMessage('deal'), 'sort' => 'UF_DEAL_ID', 'default' => true],  
      ['id' => 'UF_AWARD_AMOUNT', 'name' => GetMessage('award_amount'), 'sort' => 'UF_AWARD_AMOUNT', 'default' => true],
      ['id' => 'UF_AWARD_TIME', 'name' =>  GetMessage('date'), 'sort' => 'UF_AWARD_TIME', 'default' => true],  
    ], 
    'ROWS' => $arResult->grid_items_list,
    'SHOW_ROW_CHECKBOXES' => false, 
    'NAV_OBJECT' => $arResult->nav, 
    'AJAX_MODE' => 'Y', 
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''), 
    'PAGE_SIZES' => [ 
      ['NAME' => "5", 'VALUE' => '5'], 
      ['NAME' => '10', 'VALUE' => '10'], 
      ['NAME' => '20', 'VALUE' => '20'], 
      ['NAME' => '50', 'VALUE' => '50'], 
      ['NAME' => '100', 'VALUE' => '100'] 
    ], 
    'AJAX_OPTION_JUMP'          => 'N', 
    'SHOW_CHECK_ALL_CHECKBOXES' => true, 
    'SHOW_ROW_ACTIONS_MENU'     => true, 
    'SHOW_GRID_SETTINGS_MENU'   => true, 
    'SHOW_NAVIGATION_PANEL'     => true, 
    'SHOW_PAGINATION'           => true, 
    'SHOW_SELECTED_COUNTER'     => false, 
    'SHOW_TOTAL_COUNTER'        => false, 
    'SHOW_PAGESIZE'             => true, 
    'SHOW_ACTION_PANEL'         => false, 
    'ACTION_PANEL'              => [ 
      'GROUPS' => [ 
        'TYPE' => [ 
          'ITEMS' => [ 
            [ 
              'ID'    => 'set-type', 
              'TYPE'  => 'DROPDOWN', 
              'ITEMS' => [ 
                ['VALUE' => '', 'NAME' => '- Выбрать -'], 
                ['VALUE' => 'plus', 'NAME' => 'Поступление'], 
                ['VALUE' => 'minus', 'NAME' => 'Списание'] 
              ] 
            ], 
          ], 
        ] 
      ], 
    ], 
    'ALLOW_COLUMNS_SORT'        => true, 
    'ALLOW_COLUMNS_RESIZE'      => true, 
    'ALLOW_HORIZONTAL_SCROLL'   => true, 
    'ALLOW_SORT'                => true, 
    'ALLOW_PIN_HEADER'          => true, 
    'AJAX_OPTION_HISTORY'       => 'N', 
    'CURRENT_PAGE' => 5,
  ]
);

\Bitrix\Main\UI\Extension::load("ui.progressround");
include_once 'preloader.php';
?>


<script>
  $(function () {
    console.clear();
    $('.deal_award_pdf_button').click(function () {
       $('.preloader_wrapper').css({'display':'flex'});
      $.post('<?php echo $this->getComponent()->getPath();?>/ajax.php', {
        deal_award_pdf_button: 'Y',
        table_head_user: "<?php echo GetMessage('user'); ?>",
        table_head_deal: "<?php echo GetMessage('deal'); ?>",
        table_head_amount: "<?php echo GetMessage('award_amount'); ?>",
        table_head_date: "<?php echo GetMessage('date'); ?>",
      }, function (data) {
        window.open('<?php echo $this->getComponent()->getPath() ?>'+'/dompdf/report.pdf', '_blank');
        $('.preloader_wrapper').css({'display':'none'});
      });
    });
  });

</script>