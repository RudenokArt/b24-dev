<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- JQUERY -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- BOOTSTRAP -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	<!-- FONT AWESSOME -->
	<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
	<!-- JS SiGNATURE -->
	<script type="text/javascript" src="<?php echo $this->getComponent()->getPath();?>/jSignature/flashcanvas.js"></script>
	<script src="<?php echo $this->getComponent()->getPath();?>/jSignature/jSignature.min.js"></script>
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo $this->getComponent()->getPath();?>/templates/.default/style.css">
	<title><?php echo GetMessage('live_signature') ?></title>
</head>
<body>
	
	<?php if ($arResult['alert']): ?>
			<div class="alert alert-danger text-center">
				<?php echo GetMessage('invalid_password'); ?>
			</div>
		<?php endif ?>
		<?php if (isset($_SESSION['livesignature'])
			and
			$_SESSION['livesignature'] == $arResult['signature_table']['ID']): ?>
			<?php include_once 'view-page.php'; ?>
		<?php else: ?>
			<?php include_once 'login-form.php'; ?>
		<?php endif ?>
	
</body>
</html>
