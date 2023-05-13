<?php
namespace Live;
/**
 * 
 */
class DocumentGeneratorHandler {
	public static function customizeDocument($event)
	{	
    $event->setValues(['signature' => '${signature}']);
    // // // добавить дополнительные описания полей
    // // // $document->setFields($newFields);
    // // // добавить значения полей
		// $document->setValues(['signature' => '${signature}']);
    // // // получить список полей и их текущих значений
    // // //$fields = $document->getFields();
	}
}

?>