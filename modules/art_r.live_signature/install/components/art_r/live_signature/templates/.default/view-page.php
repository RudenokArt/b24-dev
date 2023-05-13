<div class="row">
	<div class="col-lg-8 col-md-12 col-sm-12">
		<iframe
		style="width: 100%; height: 80vh;"
		src="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo $arResult['doc_file_url'];?>?v=<?php echo time();?>"></iframe>
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