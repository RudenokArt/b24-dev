<?php 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<tr>
  <td><?php echo GetMessage('document_id') ?>:</td>
<td style="width:60%">
  <?=CBPDocument::showParameterField('doc_id', 'doc_id', $arCurrentValues['doc_id'], Array('rows' => 1))?>
</td>
</tr>