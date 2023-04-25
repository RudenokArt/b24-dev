<?php 
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
use Bitrix\UI\Toolbar\Facade\Toolbar;
Toolbar::DeleteFavoriteStar();
$arResult->getDealFieldsList();
?>

<div class="container">
	<form action="" method="post" class="row">
		<?php foreach ($arResult->dealFieldsList as $key => $value): ?>
			<div class="form-check form-switch col-4">
				<label class="form-check-label">
					<input <?php if ($arResult->dealFieldsFilter[$value['title']] == 'on'): ?>
						checked
					<?php endif ?> name="deal_fields[<?php echo $value['title'];?>]" class="form-check-input" type="checkbox">
					<?php if ($value['listLabel']): ?>
						<?php echo $value['listLabel'] ?>
						/
					<?php endif ?>
					<?php echo $value['title']; ?>
				</label>
			</div>
		<?php endforeach ?>
		<?$APPLICATION->IncludeComponent('bitrix:ui.button.panel', '', [
			'BUTTONS' => [
				[
					'TYPE' => 'custom',
					'LAYOUT' => '<button class="ui-btn ui-btn-success ui-btn-icon-done">save</button>'
				],
				[
					'TYPE' => 'custom',
					'LAYOUT' => '<a href="" class="ui-btn ui-btn-success-light">cancel</a>'
				],
			]
		]);?>
	</form>
</div>




<pre><?php print_r($arResult->dealFieldsFilter); ?></pre>
