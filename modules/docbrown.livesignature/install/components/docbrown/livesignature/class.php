<?php 

/**
 * 
 */
class LivesignatureComponent extends CBitrixComponent {
	
	public function init() { 

		$this->data['signature_table'] = Bitrix\Livesignature\LivesignatureTable::getList([
			'filter' => [
				'ID' => $_GET['id'],
			],
		])->fetch();

		$this->data['document_table'] = Bitrix\DocumentGenerator\Model\DocumentTable::getList([
			'filter' => [
				'ID' => $this->data['signature_table']['FILE_ID'],
			],
			'select' => ['ID', 'FILE_ID', 'IMAGE_ID', 'PDF_ID'],
		])->fetch();

		$this->data['doc_file'] = $this->getArFile($this->data['document_table']['FILE_ID']);
		$this->data['img_file'] = $this->getArFile($this->data['document_table']['IMAGE_ID']);
		$this->data['pdf_file'] = $this->getArFile($this->data['document_table']['PDF_ID']);

		$this->data['invalid_file_format'] = false;
		if (isset($_FILES['upload_signature'])) {
			if ($_FILES['upload_signature']['type'] == 'image/png'){
				move_uploaded_file($_FILES['upload_signature']['tmp_name'], __DIR__.'/signature.png');
				$sign_image_file = '/signature.png';
				$this->saveSignedDoc($sign_image_file);
			} elseif ($_FILES['upload_signature']['type'] == 'image/jpeg') {
				move_uploaded_file($_FILES['upload_signature']['tmp_name'], __DIR__.'/signature.jpg');
				$sign_image_file = '/signature.jpg';
				$this->saveSignedDoc($sign_image_file);
			} else {
				$this->data['invalid_file_format'] = true;
			}
		}


		if (isset($_POST['signature'])) {
			$this->base64ToPng($_POST['signature']);
			$sign_image_file = '/signature.png';
			$this->saveSignedDoc($sign_image_file);
		}

	}

	public function getArFile ($id) {
		// $documentgenerator_file = Bitrix\DocumentGenerator\Model\FileTable::getList([
		// 	'filter' => ['ID' => $id,]
		// ])->fetch();
		$b_file_id =  Bitrix\DocumentGenerator\Model\FileTable::getBFileId($id);
		$b_file = CFile::GetFileArray($b_file_id);
		return $b_file;
	}

	function base64ToPng ($base64_string) {
		$ifp = fopen($_SERVER['DOCUMENT_ROOT'].$this->getPath().'/signature.png', "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
	}

	function saveSignedDoc ($sign_image_file) {
		$phpWord = new  \PhpOffice\PhpWord\PhpWord();
		$_doc = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER['DOCUMENT_ROOT'].$this->data['doc_file']['SRC']);
		$_doc->setImageValue('signature', __DIR__.$sign_image_file);
		$tmp_doc_path = $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'
		.$this->data['signature_table']['ID'].'.'
		.pathinfo($_SERVER['DOCUMENT_ROOT'].$this->data['doc_file']['SRC'])['extension'];
		$_doc->saveAs($tmp_doc_path);

		$this->data['tmp_doc_path'] = $tmp_doc_path;

		$signed_doc_file = CFile::SaveFile(CFile::makeFileArray($tmp_doc_path), 'livesignature');

		Bitrix\Livesignature\LivesignatureTable::update($this->data['signature_table']['ID'], [
			'SIGNATURE' => 'Y',
		]);

		$transformer = new Bitrix\Transformer\DocumentTransformer;
		$transformer->transform($signed_doc_file, ['pdf', 'jpg'], 'pull', Bitrix\Livesignature\Pdf::class, [
			'fileId' => $signed_doc_file,
			'pdf' => $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'.$this->data['signature_table']['ID'].'.pdf',
			'jpg' => $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'.$this->data['signature_table']['ID'].'.jpg',
			'document_table' => $this->data['document_table']['ID']
		])->isSuccess();

	}


}

?>