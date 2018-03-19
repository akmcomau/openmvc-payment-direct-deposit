<table style="background-color: #FFF;width: 100%;padding: 20px; max-width: 500px;">
<thead>
<tr>
<th colspan="2" style="text-align: left;"><?php echo $text_direct_deposit; ?></th>
</tr>
</thead>
<tr>
<th style="text-align: right;border-top: 1px solid #ddd;"><?php echo $text_bank; ?>: </th>
<td style="border-top: 1px solid #ddd;"><?php echo $module_config->bank; ?></td>
</tr>
<tr>
<th style="text-align: right;border-top: 1px solid #ddd;"><?php echo $text_bsb; ?>: </th>
<td style="border-top: 1px solid #ddd;"><?php echo $module_config->bsb; ?></td>
</tr>
<tr>
<th style="text-align: right;border-top: 1px solid #ddd;"><?php echo $text_account_number; ?>: </th>
<td style="border-top: 1px solid #ddd;"><?php echo $module_config->account_number; ?></td>
</tr>
<tr>
<th style="text-align: right;border-top: 1px solid #ddd;"><?php echo $text_deposit_description; ?>: </th>
<td style="border-top: 1px solid #ddd;"><?php echo $deposit_description;  ?></td>
</tr>
</table>
