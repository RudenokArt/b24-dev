<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php GetMessage('live_signature'); ?></title>
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<!-- BOOTSTRAP -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<!-- FONT AWESSOME -->
	<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
	<!-- JS SiGNATURE -->
	<script type="text/javascript" src="<?php echo $this->getComponent()->getPath();?>/jSignature/flashcanvas.js"></script>
	<script src="<?php echo $this->getComponent()->getPath();?>/jSignature/jSignature.min.js"></script>
</head>
<body>
	<div class="container pt-5">
		<?php if ($arResult['alert']): ?>
			<div class="alert alert-danger text-center">
				<?php echo GetMessage('incorrect_password'); ?>
			</div>
		<?php endif ?>
		<?php if (isset($_SESSION['live_signature'])
			and
			$_SESSION['live_signature'] == $arResult['signature']['ID']): ?>
			<?php include_once 'view-page.php'; ?>
		<?php else: ?>
			<?php include_once 'login-form.php'; ?>
		<?php endif ?>
	</div>
</body>
</html>
<pre><?php print_r($arResult); ?></pre>

