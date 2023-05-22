<?php
class AwardReportAjaxController extends Bitrix\Main\Engine\Controller {

	public function configureActions() {

		return [
			'download' => [
            	'prefilters' => []
        	]
		];

	}

    public function downloadAction($fileId, $fileName) {

		return Bitrix\Main\Engine\Response\BFile::createByFileID($fileId, $fileName);

	}

	public function generateDownloadLinkAction($fileId, $fileName) {

		return Bitrix\Main\Engine\UrlManager::getInstance()->createByComponentController(

			$this, 'download', ['fileId' => Bitrix\Disk\File::loadById($fileId)->getFileId(), 'fileName' => $fileName]

		);

	}

}
?>