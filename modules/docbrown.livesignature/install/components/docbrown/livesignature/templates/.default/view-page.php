<div class="container pt-5">

	<div class="row">

		<div class="col-lg-8 col-md-12 col-sm-12">
			<iframe
			id="show_pdf"
			src="<?php echo $this->getComponent()->getPath();?>/pdf_viewer.php?path=<?php echo $arResult['pdf_file']['SRC'];?>?v=<?php echo time();?>"
			style="width: 100%; height: 80vh; border: none;"
			></iframe>
		</div>

		<div class="col-lg-4 col-md-12 col-sm-12 live_signature-signature-bg">
			<?php if ($arResult['signature_table']['SIGNATURE'] == 'Y'): ?>
				<div class="row align-items-center">
				<div class="col-6">
					<img src="<?php echo $this->getComponent()->getPath();?>/img/signature.png" alt="signature" class="w-100">
				</div>
				<div class="col-6 h1 text-secondary">
					<i class="fa fa-handshake-o" aria-hidden="true"></i>
				</div>
			</div>
				<div class="alert alert-success">
					<?php echo GetMessage('allready_signed') ?>
				</div>
			<?php else: ?>
				<div id="signature" class="card"></div>
				<div class="row pt-2">
					<div class="col-6">
						<button class="btn btn-danger w-100" id="jSignature_reset">
							<i class="fa fa-times" aria-hidden="true"></i>
							<?php echo GetMessage('clear') ?>
						</button>
					</div>
					<div class="col-6">
						<button class="btn btn-success w-100" id="jSignature_save">
							<i class="fa fa-check" aria-hidden="true"></i>
							<?php echo GetMessage('sign'); ?>
						</button>
					</div>
					<form action="" method="post" id="jSignature_form">
						<input type="hidden" id="jSignature_input" name="signature">
					</form>
				</div>

				<div class="row align-items-center">
				<div class="col-6">
					<img src="<?php echo $this->getComponent()->getPath();?>/img/signature.png" alt="signature" class="w-100">
				</div>
				<div class="col-6">
					<div class="h5 alert alert-light">
						<?php echo GetMessage('sign_or_upload'); ?>
					</div>
				</div>
			</div>

				<form action="" enctype="multipart/form-data" method="post" class="row pt-2" id="upSign_form">
					<div class="col-12">
						<div class="p-2 text-light card text-center bg-secondary mb-2 upSign_wrapper">
						<div class="h1">
							<i class="fa fa-cloud-upload" aria-hidden="true"></i>
							<span class="h6" id="upSign_filename"></span>
						</div>
						<div><?php echo GetMessage('available_formats');?>: jpg, png</div>
						<input type="file" name="upload_signature" id="upSign" required>
					</div>
					</div>
					
					<div class="col-6">
						<button class="btn btn-danger w-100" id="upSign_reset">
							<i class="fa fa-times" aria-hidden="true"></i>
							<?php echo GetMessage('clear') ?>
						</button>
					</div>
					<div class="col-6">
						<button class="btn btn-success w-100" id="upSign_save">
							<i class="fa fa-check" aria-hidden="true"></i>
							<?php echo GetMessage('sign'); ?>
						</button>
					</div>
					<?php if ($arResult['invalid_file_format']): ?>
						<div class="col-12 pt-1">
							<div class="alert alert-danger">
								<?php echo GetMessage('invalid_file_format'); ?>
							</div>
						</div>
					<?php endif ?>
				</form>

			<?php endif ?>
		</div>

	</div>

</div>

<div class="preloader_wrapper" id="preloader_wrapper">
	<div class="preloader_inner">
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
	</div>
</div>

<?php if ((isset($_POST['signature']) or isset($_FILES['upload_signature'])) and !$arResult['invalid_file_format'] ): ?>
	<script>
		$(function () {
			$('.preloader_wrapper').css({'display':'flex'});
			checkGeneratedFiles();
			function checkGeneratedFiles () {
				$.post('', {
					check_generated_files: 'Y',
					pdf: "<?php echo $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'.$arResult['signature_table']['ID'].'.pdf'?>",
					jpg: "<?php echo $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'.$arResult['signature_table']['ID'].'.jpg'?>"
				}, function (data) {
					if (data == 'Y') {
						$.post('', {
							update_generated_files: 'Y',
							pdf: "<?php echo $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'.$arResult['signature_table']['ID'].'.pdf'?>",
							jpg: "<?php echo $_SERVER['DOCUMENT_ROOT'].'/upload/livesignature/'.$arResult['signature_table']['ID'].'.jpg'?>",
							doc: "<?php echo $arResult['tmp_doc_path']?>",
							document_table: "<?php echo $arResult['document_table']['ID'] ?>"
						}, function (data) {
							$('.preloader_wrapper').css({'display':'none'});
							window.location.href = '';
						});
					} else {
						setTimeout(function () {
							checkGeneratedFiles();
						}, 1000);
					}
				});
			}
		});			
	</script>
<?php endif ?>

<script>

	$(document).ready(function() {

		$('#upSign').change(function () {
			$('#upSign_filename').html(this.value);
		});

		$('#upSign_reset').click(function (e) {
			e.preventDefault();
			$('#upSign').prop('value', '');
			$('#upSign_filename').html('');
		});

		var jSig = $("#signature");
		jSig.jSignature();
		$('#jSignature_reset').click(function () {
			jSig.jSignature('reset');
		});

		$('#jSignature_save').click(function () {
			$('#jSignature_input').attr('value', jSig.jSignature('getData'));
			$('#jSignature_form').trigger('submit');				
		});

	});

</script>