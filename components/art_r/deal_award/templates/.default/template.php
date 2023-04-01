<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
foreach ($arResult->itemsList as $key => $value) {

  $deal_award_items_list[] = [
        'data'    => [ //Данные ячеек
        "ID" => $value['ID'],
        "USER_ID" => $value['UF_USER_ID'],
        "DEAL_ID" => $value['UF_DEAL_ID'],
        "AWARD_AMOUNT" => $value['UF_AWARD_AMOUNT'],
      ],
        'actions' => [ //Действия над ними
        [
          'text'  => 'Редактировать',
          'onclick' => 'document.location.href="/accountant/reports/1/edit/"'
        ],
        [
          'text'    => 'Удалить',
          'onclick' => 'document.location.href="/accountant/reports/1/delete/"'
        ]

      ],
    ];
  }


  $grid_options = new Bitrix\Main\Grid\Options('report_list');
  $sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
  $nav_params = $grid_options->GetNavParams();

  $nav = new Bitrix\Main\UI\PageNavigation('report_list');
  $nav->allowAllRecords(true)
  ->setPageSize($nav_params['nPageSize'])
  ->initFromUri();

  $APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
      'GRID_ID' => 'report_list', 
      'COLUMNS' => [
        ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true], 
        ['id' => 'USER_ID', 'name' => 'user id', 'sort' => 'USER_ID', 'default' => true], 
        ['id' => 'DEAL_ID', 'name' => 'deal id', 'sort' => 'DEAL_ID', 'default' => true],  
        ['id' => 'AWARD_AMOUNT', 'name' => 'award amount', 'sort' => 'AWARD_AMOUNT', 'default' => true],  
      ], 
      'ROWS' => $deal_award_items_list,
      'SHOW_ROW_CHECKBOXES' => true, 
      'NAV_OBJECT' => $nav, 
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
      'SHOW_SELECTED_COUNTER'     => true, 
      'SHOW_TOTAL_COUNTER'        => true, 
      'SHOW_PAGESIZE'             => true, 
      'SHOW_ACTION_PANEL'         => true, 
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
      'AJAX_OPTION_HISTORY'       => 'N' 
    ]
    );?>