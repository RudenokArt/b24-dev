<?php
namespace Bitrix\Livesignature;
\Bitrix\Main\Loader::includeModule('transformer');



class Pdf implements \Bitrix\Transformer\InterfaceCallback {

	public static function init() {}

	public static function call($status, $command, $params, $result = array()) {

		copy($result['files']['pdf'], $params['pdf']);
		copy($result['files']['jpg'], $params['jpg']);


		// file_put_contents(
		// 	$_SERVER['DOCUMENT_ROOT'].'/test/test.json',
		// 	json_encode(
		// 		[
		// 			'status' => $staus,
		// 			'command' => $command,
		// 			'params' => $params,
		// 			'result' => $result,
		// 		]
		// 	)			
		// );


		

		return true;

	}

}

?>