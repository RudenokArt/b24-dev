<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
<script type="text/javascript" src="<?php echo $this->getComponent()->getPath();?>/jSignature/flashcanvas.js"></script>
<script src="<?php echo $this->getComponent()->getPath();?>/jSignature/jSignature.min.js"></script>
<style>
.preloader_wrapper {
  position: absolute;
  width: 120%;
  height: 120%;
  display: none;
  background: rgba(250, 250, 250, 0.5);
  top: -10%;
  left: -10%;
}
.preloader_inner {
  color: grey;
  font-size: 36px;
  margin: auto;
}
</style>
<div class="container pt-5">
	<div class="row justify-content-center">
		<div class="col-12 text-center">
			<iframe id="showPdf" style="width: 100%; height: 50vh;" src="<?php echo $arResult->showPdf();?>">
				<!-- loading... -->
			</iframe>
		</div>
		<div class="col-lg-6 col-md-8 col-sm-12 col-12 pt-5 h-25">
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
			</div>
		</div>
	</div>
</div>

<div class="preloader_wrapper" id="preloader_wrapper">
  <div class="preloader_inner">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
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
			$('.preloader_wrapper').css({'display':'flex'});
			$.post('', {signature:jSig.jSignature('getData')}, function (data) {
				$('#showPdf')[0].contentWindow.location.reload(true);
				$('.preloader_wrapper').css({'display':'none'});
			});
		});
	});
</script>

