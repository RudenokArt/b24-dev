<?php 

namespace Bitrix\Otpusk;

/**
 * 
 */
class BigtripRest {
	
	function OnRestServiceBuildDescription () {
		return array(
			'crm' => array(
				'otpusk.bigtrip' => array(
					'callback' => array(__CLASS__, 'restApiRequest'),
					'options' => array(),
				),
			)
		);
	}

	function restApiRequest () {
		return 
		file_put_contents(
			$_SERVER['DOCUMENT_ROOT'].'/test.json', json_encode(
				$_POST,
				JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
			)
		);
	}



}


?>