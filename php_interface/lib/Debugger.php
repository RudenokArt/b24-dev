<?php 
namespace lib;
/**
 * 
 */
class Debugger {
	
	public static function singleLog_txt ($str){
		file_put_contents(
			$_SERVER['DOCUMENT_ROOT'].'/local/log.txt',
			$str
		);
	}
}

?>