<?php

/**
 *
 */
class LiveSignature extends CBitrixComponent {

	public function init() {

		$this->live_signature['signature'] = Bitrix\Live\SignatureTable::getList([
			'filter' => ['ID' => $_GET['id'],],
		])->fetch();

		$this->live_signature['document'] = Bitrix\DocumentGenerator\Model\DocumentTable::getList([
			'filter' => ['ID' => $this->live_signature['signature']['FILE_ID']],
			'select' => ['ID', 'TITLE', 'FILE_ID', 'PDF_ID'],
		])->fetch();

		$this->live_signature['doc_id'] = Bitrix\DocumentGenerator\Model\FileTable::getBFileId(
			$this->live_signature['document']['FILE_ID']
		);

		$this->live_signature['pdf_id'] = Bitrix\DocumentGenerator\Model\FileTable::getBFileId(
			$this->live_signature['document']['PDF_ID']
		);

		$this->live_signature['doc_file'] = CFile::GetFileArray($this->live_signature['doc_id']);
		$this->live_signature['pdf_file'] = CFile::GetFileArray($this->live_signature['pdf_id']);

		$this->live_signature['doc_file_url'] = 'https://'.$_SERVER['SERVER_NAME'].$this->live_signature['doc_file']['SRC'];
		$this->live_signature['pdf_file_url'] = 'https://'.$_SERVER['SERVER_NAME'].$this->live_signature['pdf_file']['SRC'];

		$this->live_signature['doc_file_path'] = $_SERVER['DOCUMENT_ROOT'].$this->live_signature['doc_file']['SRC'];
		$this->live_signature['pdf_file_path'] = $_SERVER['DOCUMENT_ROOT'].$this->live_signature['pdf_file']['SRC'];

		$this->live_signature['result_pdf_src'] = '/upload/live_signature/'.$this->live_signature['signature']['ID'].'.pdf';
		
		if (isset($_POST['signature'])) {
			$this->base64ToPng($_POST['signature']);
			$this->saveSignedDoc();
			Bitrix\Live\SignatureTable::update($this->live_signature['signature']['ID'], [
				'SIGNATURE' => 'Y',
			]);
			$this->live_signature['signature']['SIGNATURE'] = 'Y';
			$this->convertToPdf($this->live_signature['doc_file']['ID'], $this->live_signature['result_pdf_src']);
		}

		$this->live_signature['show_pdf'] = $this->showPdf();

	}

	function showPdf () {
		// if ($this->live_signature['signature']['SIGNATURE'] == 'Y') {
		// 	return 'https://'.$_SERVER['SERVER_NAME'].$this->live_signature['result_pdf_src'];
		// }
		copy($this->live_signature['pdf_file_path'], $this->live_signature['pdf_file_path'].'.pdf');
		return $this->live_signature['pdf_file_url'].'.pdf';
	}

	function base64ToPng ($base64_string) {
		$ifp = fopen($_SERVER['DOCUMENT_ROOT'].$this->getPath().'/signature.png', "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
	}

	function saveSignedDoc () {
		$phpWord = new  \PhpOffice\PhpWord\PhpWord();
		$_doc = new \PhpOffice\PhpWord\TemplateProcessor($this->live_signature['doc_file_path']);
		$_doc->setImageValue('signature', __DIR__.'/signature.png');
		$_doc->saveAs($this->live_signature['doc_file_path']);
	}

	public static function convertToPdf($fileId, $result_pdf_src) { // b_file

		$fileId = (int) $fileId;

		if ($fileId <= 0) return false;
		if ($transformer = new Bitrix\Transformer\DocumentTransformer) {
			return $transformer->transform($fileId, ['pdf', 'jpg'], 'pull', \Bitrix\Live\Pdf::class, [
				'fileId' => $fileId,
				'result_pdf_src' => $result_pdf_src,
			])->isSuccess();

		}

		return false;

	}

}


?>