<div style="background-image: url(<?php echo $this->getComponent()->getPath();?>/img/lock.png);" 
class="row pt-5 justify-content-center live_signature-login_form-bg pb-5">
	<div class="col-lg-4 col-md-6 col-sm-12 pt-5 pb-5">
		<div class="card p-3 pt-5 pb-5 border-danger">
			<div class="card-header h4 text-secondary text-center">
				<?php echo GetMessage('password_only_access'); ?>!
			</div>
			<div class="card-body">
				<form action="" method="post">
					<div>
						<input name="password" type="password" required class="form-control" placeholder="<?php echo GetMessage('password') ?>">
					</div>
					<div class="pt-3">
						<button class="btn btn-success w-100">
							<i class="fa fa-sign-in" aria-hidden="true"></i>
							<?php echo GetMessage('login'); ?>
						</button>
					</div>	
				</form>
			</div>			
		</div>
	</div>
</div>

