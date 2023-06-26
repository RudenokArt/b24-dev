<div class="container pb-5 pt-5 deals_list-greed card">
		<?php if ($arResult['deals_arr']): ?>
			<?php foreach ($arResult['deals_arr'] as $key => $value): ?>
				<a href="/deal/<?php echo $value['ID'];?>" class="row deals_list-item p-2 mt-1 bg-light">
					<div class="col-lg-2 col-md-2 col-sm-6">
						<?php echo $value['DATE_CREATE']->format('Y-m-d'); ?>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<?php echo $value['TITLE'] ?>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-6">
						<?php echo $value['OPPORTUNITY'] ?>
						<?php echo $value['CURRENCY_ID'] ?>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12 text-primary">
						<?php $deals_list_item_stage_flag = true; ?>
						<?php foreach ($value['category']['stages_list'] as $key1 => $value1): ?>
							<?php if ($deals_list_item_stage_flag): ?>
								<i title="<?php echo $value1['NAME'] ?>" style="color: <?php echo $value1['COLOR'] ?>;" class="fa fa-square" aria-hidden="true"></i>
							<?php else: ?>
								<i title="<?php echo $value1['NAME'] ?>" class="fa fa-square-o" aria-hidden="true"></i>
							<?php endif ?>
							<?php if ($key1 == $value['STAGE_ID']): ?>
								<?php $deals_list_item_stage_flag = false; ?>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</a>
			<?php endforeach ?>
		<?php else: ?>
			<div class="alert alert-warning mt-5 text-center">
				<?php echo GetMessage('EMPTY_LIST'); ?>
			</div>
		<?php endif ?>
	</div>
