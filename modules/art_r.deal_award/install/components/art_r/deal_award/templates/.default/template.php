<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 


$APPLICATION->IncludeComponent(
  'bitrix:main.ui.filter',
  '',
  [ 
    'FILTER_ID' => 'report_list', 
    'GRID_ID' => 'report_list', 
    'FILTER' => [ 
      ['id' => 'DATE', 'name' => 'date', 'type' => 'date'],
      ['id' => 'DEAL', 'name' => 'deal', 'type' => 'string'],
      ['id' => 'USER', 'name' => 'user', 'type' => 'dest_selector'],
  ],
  'ENABLE_LIVE_SEARCH' => true, 
  'ENABLE_LABEL' => true
]
); 


$APPLICATION->IncludeComponent(
  'bitrix:main.ui.grid',
  '',
  [
    'GRID_ID' => 'report_list', 
    'COLUMNS' => [
      ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true], 
      ['id' => 'UF_USER_ID', 'name' => 'user', 'sort' => 'UF_USER_ID', 'default' => true], 
      ['id' => 'UF_DEAL_ID', 'name' => 'deal', 'sort' => 'UF_DEAL_ID', 'default' => true],  
      ['id' => 'UF_AWARD_AMOUNT', 'name' => 'award amount', 'sort' => 'UF_AWARD_AMOUNT', 'default' => true],
      ['id' => 'UF_AWARD_TIME', 'name' => 'award date', 'sort' => 'UF_AWARD_TIME', 'default' => true],  
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

