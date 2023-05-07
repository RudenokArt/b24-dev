<?php 

/**
 * 
 */
class LiveSignature extends CBitrixComponent
{

	function init ($doc_url, $pdf_url, $doc_path, $pdf_path) {
		$this->doc_url = $doc_url;
		$this->pdf_url = 'https://'.$pdf_url;
		$this->doc_path = $doc_path;
		$this->pdf_path = $pdf_path;
	}

	function showPdf () {
		$path = realpath(realpath(__DIR__) . '/dompdf');
		\PhpOffice\PhpWord\Settings::setPdfRendererPath($path);
		\PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF);
		$phpWord = \PhpOffice\PhpWord\IOFactory::load($this->doc_path); 
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
		$xmlWriter->save($this->pdf_path);
		return $this->pdf_url;
	}

	function saveResultDoc () {
		$phpWord = new  \PhpOffice\PhpWord\PhpWord(); 
		$_doc = new \PhpOffice\PhpWord\TemplateProcessor($this->doc_path);
		$_doc->setImageValue('sig', __DIR__.'/sig.png');
		$_doc->saveAs($this->doc_path);
	}

	function base64ToPng ($base64_string) {
		$ifp = fopen($_SERVER['DOCUMENT_ROOT'].$this->getPath().'/sig.png', "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
	}



}


?>