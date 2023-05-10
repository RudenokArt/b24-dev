<?php 

CModule::AddAutoloadClasses(
    '', // не указываем имя модуля
    array(
        // ключ - имя класса с простанством имен, значение - путь относительно корня сайта к файлу
      'lib\Debugger' => '/local/php_interface/lib/Debugger.php',
    )
  );



?>