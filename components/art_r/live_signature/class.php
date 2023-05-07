<?php 
CModule::IncludeModule('art_r.live_signature');
/**
 * 
 */
class LiveSignature extends CBitrixComponent {
	
	public function init () {
		$this->doc_data = $this->getDocData();
		$this->customerLogin();
		$this->template = CFile::GetFileArray($this->doc_data['FILE_ID']);
		if (isset($_POST['signature'])) {
			$this->base64ToPng($_POST['signature']);
			$this->documentSign();
		}
	}

	function documentSign () {
		$phpWord = new  \PhpOffice\PhpWord\PhpWord();
		$path = $_SERVER['DOCUMENT_ROOT'].$this->template['SRC'];
		$ext = pathinfo($path)['extension'];
		$_doc = new \PhpOffice\PhpWord\TemplateProcessor($path);
		$_doc->setImageValue('sig', __DIR__.'/sig.png');
		$_doc->saveAs(__DIR__.'/result.'.$ext);
	}

	function base64ToPng ($base64_string) {
		$ifp = fopen($_SERVER['DOCUMENT_ROOT'].$this->getPath().'/sig.png', "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
	}

	function customerLogin () {
		$this->alert = false;
		if (isset($_POST['login'])) {
			if ($_POST['password'] == $this->doc_data['PASSWORD']) {
				$_SESSION['live_signature'] = $this->doc_data['PASSWORD'];
			} else {
				$_SESSION['live_signature'] = false;
				$this->alert = true;
			}
		}
	}

	function getDocData () {
		return Bitrix\Live\SignatureTable::getList([
			'filter' => [
				'ID' => $_GET['sig_id'],
			],
		])->fetch();
	}
	
}

?>