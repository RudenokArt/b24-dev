<div class="container pt-5 pb-5">
	<div class="row profile-main_bg">
		<div class="col-lg-6 col-md-6 col-sm-12 h1 text-secondary">
			<?php echo GetMessage('Profile') ?>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="row pt-2 pb-2">
				<div class="col-6 p-2 border">
					<div class="contact-photo text-center text-secondary">
						<?php if ($arResult['contact']['PHOTO']): ?>
							<img src="<?php echo CFile::GetFileArray($arResult['contact']['PHOTO'])['SRC']; ?>" alt="">
						<?php else: ?>
							<i class="fa fa-user" aria-hidden="true"></i>
						<?php endif ?>
					</div>					
				</div>
				<div class="col-5 ml-1">
					<form action="" enctype="multipart/form-data" method="post" id="contact_photo_form">
						<div class="contact_photo_upload-bg h1 text-center text-secondary">
							<i class="fa fa-cloud-upload" aria-hidden="true"></i>
						</div>
						<input type="file" name="contact_photo" id="contact_photo_upload">
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(function () {
			$('#contact_photo_upload').change(function () {
				$('#contact_photo_form').trigger('submit');
			});
		});
	</script>


	<form method="post" action="" class="row mt-5 pt-5 pb-5 profile-main_bg">
		<?php foreach ($arResult['contact'] as $key => $value): ?>
			<?php if ($key != 'PHOTO'): ?>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="input-group mb-3">
						<span class="input-group-text">
							<?php if ($arResult['contact_fields'][$key]): ?>
								<?php echo $arResult['contact_fields'][$key]; ?>
							<?php else: ?>
								<?php echo GetMessage($key); ?>
							<?php endif ?>
						</span>
						<input <?php if ($key == 'ID'): ?>
						readonly
					<?php endif ?> name="<?php echo $key; ?>" <?php if ($key == 'EMAIL'): ?>
					type="email"
				<?php elseif ($key == 'UF_USER_PASSWORD'): ?>
					type="password"
				<?php else: ?>
					type="text"
					<?php endif ?> value="<?php echo $value; ?>" class="form-control">
				</div>
			</div>
		<?php endif ?>
	<?php endforeach ?>
	<div class="col-12 text-center">
		<button name="contact_update" class="btn btn-primary w-50">
			<i class="fa fa-floppy-o" aria-hidden="true"></i>
			<?php echo GetMessage('Save'); ?>
		</button>
	</div>
</form>
</div>

