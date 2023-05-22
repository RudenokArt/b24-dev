<?php
class AwardReportComponent extends CBitrixComponent {

	protected $pdfId;
	protected $xlsId;
	protected $pdfName;
	protected $xlsName;
	protected $pdfPathFileDetail;
	protected $excelPathFileDetail;

	protected function getTitle() {

		return $this->arParams['DATE_FROM'] !== '' && $this->arParams['DATE_TO'] !== '' ?
			'[' . new Bitrix\Main\Type\Date($this->arParams['DATE_FROM']) . ' - ' . new Bitrix\Main\Type\Date($this->arParams['DATE_TO']) . ']' :
			'[' . getMessage('AWARD_REPORT_ALL_TIME') . ']';

	}

	protected function getMenuitems($choice) {

		return [
			'items' => [
				['id' => 'PDF', 'text' => getMessage('AWARD_REPORT_PDF'), 'onclick' => new Bitrix\UI\Buttons\JsCode('BX.Award.Report.SelectType("' . $choice . '_PDF", this)')],
				['id' => 'EXCEL', 'text' => getMessage('AWARD_REPORT_EXCEL'), 'onclick' => new Bitrix\UI\Buttons\JsCode('BX.Award.Report.SelectType("' . $choice . '_EXCEL", this)')]
			],
			'closeByEsc' => true
		];

	}

	protected function getPdfAjaxController() {

		$file = Bitrix\Disk\File::loadById($this->arParams['PDF']);
		$this->pdfId = $file->getId();
		$this->pdfName = $file->getName();
		$this->pdfPathFileDetail = Bitrix\Disk\Driver::getInstance()->getUrlManager()->getPathFileDetail($file);

		return $this->getAjaxController($file);

	}

	protected function getExcelAjaxController() {

		$file = Bitrix\Disk\File::loadById($this->arParams['EXCEL']);
		$this->xlsId = $file->getId();
		$this->xlsName = $file->getName();
		$this->excelPathFileDetail = Bitrix\Disk\Driver::getInstance()->getUrlManager()->getPathFileDetail($file);

		return $this->getAjaxController($file);

	}

	private function getAjaxController(Bitrix\Disk\File $file) {

		$documentSessionContext = new Bitrix\Disk\Document\OnlyOffice\Models\DocumentSessionContext($file->getId());
		$sessionManager = new Bitrix\Disk\Document\OnlyOffice\DocumentSessionManager();
		$sessionManager
			->setUserId($GLOBALS['USER']->getId())
			->setSessionType(Bitrix\Disk\Document\OnlyOffice\Models\DocumentSession::TYPE_VIEW)
			->setSessionContext($documentSessionContext)
			->setFile($file);

		return Bitrix\Main\Engine\UrlManager::getInstance()->create(
			'disk.controller.documentservice.viewDocument',
			[
				'documentSessionId' => $sessionManager->findOrCreateSession()->getId()
			]
		);

	}

}
?>