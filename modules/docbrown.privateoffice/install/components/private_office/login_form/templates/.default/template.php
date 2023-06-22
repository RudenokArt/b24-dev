<div class="container pt-5 pb-5 login_form-bg" 
style="background-image: url(<?php echo $this->getComponent()->getPath().'/img/lock.png'; ?>);">
<div class="row">
	<div class="col-12 text-center alert alert-<?php echo $arResult['alert']['color'] ?>">
		<?php echo $arResult['alert']['text'] ?>
	</div>
</div>
<div class="row pt-5 pb-5 justify-content-center">
	<div class="col-lg-4 col-md-6 col-sm-12">
		<form method="post" action="" class="card p-3 login_form-card">
			<div class="card-header">
				<?php echo GetMessage('Authorization') ?>
			</div>
			<div class="card-body">
				<div class="h6"><?php echo GetMessage('Login') ?>:</div>
				<input name="login" type="text" class="form-control" required>
				<div class="h6"><?php echo GetMessage('Password') ?>:</div>
				<input name="password" type="text" class="form-control" required>
				<div class="pt-3">
					<button class="btn btn-primary w-100">
						<i class="fa fa-sign-in" aria-hidden="true"></i>
						<?php echo GetMessage('Sign_in') ?>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
