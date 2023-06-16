<?php
\Bitrix\Main\UI\Extension::load("ui.buttons.icons");
\Bitrix\Main\UI\Extension::load("ui.buttons"); 
?>
<div class="container">
	<div class="row border-bottom">
		<div class="col-4"><?php echo GetMessage('DATE');?>:</div>
		<div class="col-8 h6"><?php echo ConvertTimeStamp($arResult['operation']['DATE']) ?></div>
	</div>
	<div class="row border-bottom">
		<div class="col-4"><?php echo GetMessage('ACCOUNT');?>:</div>
		<div class="col-8 h6"><?php echo $arResult['operation']['ACCOUNT'] ?></div>
	</div>
	<div class="row border-bottom">
		<div class="col-4"><?php echo GetMessage('AMOUNT');?>:</div>
		<div class="col-8 h6"><?php echo $arResult['operation']['AMOUNT'] ?></div>
	</div>
	<div class="row border-bottom">
		<div class="col-4"><?php echo GetMessage('CURRENCY');?>:</div>
		<div class="col-8 h6"><?php echo $arResult['currency_list'][$arResult['operation']['CURRENCY']]; ?></div>
	</div>
	<div class="row border-bottom">
		<div class="col-4"><?php echo GetMessage('PAYER');?>:</div>
		<div class="col-8 h6"><?php echo $arResult['operation']['PAYER'] ?></div>
	</div>
	<div class="row pt-5">
		<div class="col-12 border p-1">
			<?php
			$APPLICATION->IncludeComponent(
				'bitrix:main.user.selector',
				'',
				[
					"ID" => "link_crm_input",
					'INPUT_NAME' => "link_crm_input",
					'USE_SYMBOLIC_ID' => true,
					'API_VERSION' => 2,
					"SELECTOR_OPTIONS" =>  [
						'enableUsers' => 'N',
						'enableAll' => 'N',
						'enableDepartments' => 'N',
						'crmPrefixType' => 'SHORT',
						'enableCrm' => 'Y',
						'enableCrmDeals' => 'Y',
						'addTabCrmDeals' => 'Y',
						'enableCrmLeads' => 'Y',
						'addTabCrmLeads' => 'Y',
					],
				]
			);
			?> 	
		</div>
	</div>
	<div class="row pt-5">
		<div class="col-12 text-center">
			<button class="ui-btn ui-btn-primary ui-btn-icon-done" id="link_crm_button">
				<?php echo GetMessage('LINK'); ?>
			</button>
		</div>
	</div>
</div>

<script>
	$(function () {
		$('#link_crm_button').click(function () {
			var crm_id = $('input[name="link_crm_input"]').prop('value');
			var item_id = "<?php echo $_GET['update']; ?>";
			BX.ajax.runComponentAction(
				'docbrown:tinkoff',
				'linkCrm',
				{
					mode: 'ajax',
					data: {
						crm: crm_id,
						item: item_id
					},
				}).then(function (result){
					BX.SidePanel.Instance.close([immediately=false]);
					var gridObject = top.BX.Main.gridManager.getById('tinkoff_operations_list');
					if (gridObject.hasOwnProperty('instance')){
						gridObject.instance.reloadTable('POST', {apply_filter: 'N', clear_nav: 'N'});
					}
				});
			});
	});
</script>
