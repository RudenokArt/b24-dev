<?$prefix = toUpper(str_replace('.', '_', getModuleId(__DIR__)));?>
<form action="<?=$APPLICATION->getCurPage(); ?>">
	<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?=LANG?>">
	<input type="hidden" name="id" value="<?=getModuleId(__DIR__)?>">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<p><?=getMessage($prefix . '_INSTALL_UNSTEP1_PARAGRAPH')?></p>
	<p>
		<input type="checkbox" name="savedata" id="savedata" checked>
		<label for="savedata"><?=getMessage($prefix . '_INSTALL_UNSTEP1_LABEL')?></label>
	</p>
	<input type="submit" value="<?=getMessage($prefix . '_INSTALL_UNSTEP1_SUBMIT')?>">
</form>