<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arr_doc_templates = Bitrix\DocumentGenerator\Model\TemplateTable::getList()->fetchAll();
?>
<tr>
  <td>Template: </td>
<td>
  <select name="doc_template" style="width:75%">
    <?php foreach ($arr_doc_templates as $key => $value): ?>
      <option value="<?php echo $value['FILE_ID']; ?>">
        <?php echo $value['NAME']; ?>
      </option>
    <?php endforeach ?>
  </select>
</td>
</tr>
