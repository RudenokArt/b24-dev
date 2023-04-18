<?php 
namespace Bitrix\Klimsol;
// \Bitrix\Main\Loader::includeModule('rest');
class RestTest 
// extends \IRestService
{
   public static function OnRestServiceBuildDescription()
   {
      return array(
         'crm' => array(
            'sigurdtest.test' => array(
               'callback' => array(__CLASS__, 'test'),
               'options' => array(),
            ),
         )
      );
   }

   public static function test()
   {
      
      return 'hello';
   }
}

// AddEventHandler('rest', 'OnRestServiceBuildDescription', array('\RestTest', 'OnRestServiceBuildDescription'));

?>