<style>
.preloader_wrapper {
  position: fixed;
  width: 120%;
  height: 120%;
  display: none;
  background: rgba(0, 0, 0, 0.5);
  top: -10%;
  left: -10%;
}
.preloader_inner {
  color: white;
  font-size: 36px;
  margin: auto;
}
</style>


<div class="row">
	<div class="col-lg-8 col-md-12 col-sm-12">
		<iframe src="<?php echo $arResult['show_pdf'];?>" id="show_pdf"
			style="width: 100%; height: 80vh; border: none;"></iframe>
	</div>
	<div class="col-lg-4 col-md-12 col-sm-12">
		<?php if ($arResult['signature']['SIGNATURE'] == 'Y'): ?>
			<div class="alert alert-success">
				<?php echo GetMessage('allready_signed') ?>
			</div>
		<?php else: ?>
			<div id="signature" class="card"></div>
			<div class="row pt-2">
				<div class="col-6">
					<button class="btn btn-outline-danger w-100" id="jSignature_reset">
						<i class="fa fa-times" aria-hidden="true"></i>
					</button>
				</div>
				<div class="col-6">
					<button class="btn btn-outline-success w-100" id="jSignature_save">
						<i class="fa fa-check" aria-hidden="true"></i>
					</button>
				</div>
				<form action="" method="post" id="jSignature_form">
					<input type="hidden" id="jSignature_input" name="signature">
				</form>
			</div>
		<?php endif ?>
	</div>
</div>


<div class="preloader_wrapper" id="preloader_wrapper">
  <div class="preloader_inner">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
  </div>
</div>

<?php if ($arResult['signature']['SIGNATURE'] == 'Y'): ?>
	<script>
		$(function () {
			checkResultPdf();
			function checkResultPdf () {
				$('.preloader_wrapper').css({'display':'flex'});

				$.post('', {
					pdf_for_iframe:"<?php echo $_SERVER['DOCUMENT_ROOT'].$arResult['result_pdf_src'];?>",
					jpg_result: "<?php echo $_SERVER['DOCUMENT_ROOT'].$arResult['result_jpg_src'];?>",
				}, function (data) {
					console.log(data);
					if (!data) {
						setTimeout(checkResultPdf, 1000);
					} else {
						$('#show_pdf').attr('src', "<?php echo $arResult['result_pdf_src'];?>");
						$('.preloader_wrapper').css({'display':'none'});
						$.post('', {
							docx_result: "<?php echo $arResult['doc_file_path']; ?>",
							jpg_result: "<?php echo $_SERVER['DOCUMENT_ROOT'].$arResult['result_jpg_src'];?>",
							pdf_result: "<?php echo $_SERVER['DOCUMENT_ROOT'].$arResult['result_pdf_src'];?>",
							pdf_update: "<?php echo $arResult['document']['ID']; ?>",
						}, function() {
							console.log(data);
						});
					}
				});

			}
		});
	</script>
<?php endif ?>


<script>
	$(document).ready(function() {
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