<?php
namespace Bitrix\Live;

class Pdf implements \Bitrix\Transformer\InterfaceCallback {

	public static function init() {}

	public static function call($status, $command, $params, $result = array()) {

		// Bitrix\Transformer\FileTransformer::clearInfoCache($params['fileId']);

		// if($status === 1000) return true;

		// foreach (['pdf', 'jpg'] as $format) {

		// 	if($file = $result['files'][$format]) {

		// 		$result[$format] = CFile::saveFile(CFile::makeFileArray($file), getModuleId(__DIR__));

		// 	}

		// }

		$test = $result['files']['pdf'];
		copy($result['files']['pdf'], $_SERVER['DOCUMENT_ROOT'].$params['result_pdf_src']);

		

		/*

		$result[pdf] = 123;
		$result[jpg] = 124;

		*/

		

		return true;

	}

}

?>