<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	CJSCore::Init(array("jquery"));
	\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
	$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
	$APPLICATION->ShowHead();
	if (
		!$_SESSION['private_office']['contact']
		and
		$_SERVER['SCRIPT_URL'] != '/login/'
	) {
		header('Location: /login/');
	}
	?>
	<link rel="icon" href="<?php echo SITE_TEMPLATE_PATH.'/assets/img/favicon.ico';?>" type="image/x-icon">
	<title><?php echo $APPLICATION->ShowTitle(); ?></title>
</head>
<body>

	<?php if ($_SERVER['SCRIPT_URL'] != '/login/'): ?>
		<div class="header bg-light">
			<div class="container pt-1 pb-1">
				<div class="row justify-content-between">
					<div class="col-lg-2 col-md-4 col-sm-6">
						<a href="/">
							<img src="<?php echo SITE_TEMPLATE_PATH.'/assets/img/logo.png';?>" class="w-100" alt="logo">
						</a>
					</div>
					<div class="col-lg-8 col-md-4 d-none d-lg-block d-md-block"></div>
					<div class="col-lg-2 col-md-4 col-sm-6 p-1 pt-3">
						<div class="row">
							<div class="col-10">
								<?php 
								$APPLICATION->IncludeComponent(
									"private_office:contact",
									"",
									Array()
								);
								?>
							</div>
							<div class="col-2">
								<a href="/login/?logout=Y" class="h5">
									<i class="fa fa-sign-out" aria-hidden="true"></i>
								</a>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif ?>