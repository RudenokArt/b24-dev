
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
<script type="text/javascript" src="<?php echo $this->getComponent()->getPath();?>/jSignature/flashcanvas.js"></script>
<script src="<?php echo $this->getComponent()->getPath();?>/jSignature/jSignature.min.js"></script>

<?php if ($arResult->alert): ?>
	<div class="container pt-5">
		<div class="alert alert-danger text-center">
			<?php echo GetMessage('invalid_password'); ?>
		</div>
	</div>
<?php endif ?>

<?php if (
	!isset($_SESSION['live_signature'])
	or
	$_SESSION['live_signature'] !== $arResult->doc_data['PASSWORD']
): ?>
<div class="container pt-5">
	<div class="row pt-5 justify-content-center">
		<div class="col-lg-4 col-md-6 col-sm-12 col-12">
			<form action="" method="post" class="border">
				<div class="p-3">
					<input type="password" placeholder="password" class="form-control" name="password">
				</div>
				<div class="p-3">
					<button class="btn btn-lg btn-success w-100" name="login" value="Y">
						<i class="fa fa-check" aria-hidden="true"></i>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif ?>

<?php if (
	isset($_SESSION['live_signature'])
	and
	$_SESSION['live_signature'] === $arResult->doc_data['PASSWORD']
): ?>
<div class="container pt-5">
	<div class="row">
		<div class="col-lg-8 col-md-6 col-sm-12">
			<a href="<?php echo $arResult->template['SRC'];?>">template</a>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12">
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
					<input type="hidden" name="signature" id="jSignature_input">
				</form>
			</div>
		</div>
	</div>
</div>
<?php endif ?>


<pre><?php var_dump($_SESSION['live_signature'] == $arResult->doc_data['PASSWORD']); ?></pre>
<pre><?php print_r($arResult->doc_data); ?></pre>


<script>
	$(document).ready(function() {

		var jSig = $("#signature");
		jSig.jSignature();

		$('#jSignature_reset').click(function () {
			jSig.jSignature('reset');
		});

		$('#jSignature_save').click(function () {
			$('#jSignature_input').prop('value', jSig.jSignature('getData'));
			$('#jSignature_form').trigger('submit');
		});

	});
</script>