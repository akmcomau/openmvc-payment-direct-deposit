<div class="row">
	<div class="col-md-12">
		<h4><?php echo $text_direct_deposit; ?></h4>
		<div id="cc-error" class="form-error"></div>
		<hr class="separator-2column" />
		<div class="row">
			<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_bank; ?>:</div>
			<div class="col-md-9 col-sm-9 ">
				<?php echo $module_config->bank; ?>
			</div>
		</div>
		<hr class="separator-2column" />
		<div class="row">
			<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_bsb; ?>:</div>
			<div class="col-md-9 col-sm-9 ">
				<?php echo $module_config->bsb; ?>
			</div>
		</div>
		<hr class="separator-2column" />
		<div class="row">
			<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_account_number; ?>:</div>
			<div class="col-md-9 col-sm-9 ">
				<?php echo $module_config->account_number; ?>
			</div>
		</div>
		<hr class="separator-2column" />
		<div class="row">
			<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_deposit_description; ?>:</div>
			<div class="col-md-9 col-sm-9 ">
				<?php echo $deposit_description; ?>
			</div>
		</div>
	</div>
</div>
