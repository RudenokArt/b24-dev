<div class="container pt-5" id="deal_detail">
	<div class="row text-secondary pb-5">
		<div class="col-12 h3">
			<?php echo GetMessage('DEAL') ?> # <?php echo $arResult['deal']['ID'] ?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 h6">
			<?php echo $arResult['deal']['TITLE'] ?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 h6">
			<?php echo $arResult['deal']['DATE_CREATE']->format('Y-m-d') ?>
			<?php echo $arResult['deal']['OPPORTUNITY'] ?>
			<?php echo $arResult['deal']['CURRENCY_ID'] ?>
		</div>
		<div class="col-12 deal_detail-status_list text-black">
				<?php $deal_detail_status_flag = true; ?>
			<?php foreach ($arResult['status_list'] as $key => $value): ?>
				<div <?php if ($deal_detail_status_flag): ?>
					style="background-color: <?php echo $value['COLOR']; ?>;"
				<?php endif ?> class="deal_detail-status_item p-1 border">
					<?php echo $value['NAME']; ?>
				</div>
				<?php if ($value['STATUS_ID'] == $arResult['deal']['STAGE_ID']): ?>
					<?php $deal_detail_status_flag = false; ?>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
	<div class="card p-1">
		<div class="bg-light">
			<ul class="nav nav-tabs">
				<?php foreach (['DETAILS', 'FAQ', 'SUPPORT'] as $key => $value): ?>
					<li class="nav-item" v-on:click.prevent="setCurrentTab('<?php echo $value; ?>')">
						<a class="nav-link" href="#" v-bind:class="isActiveTab('<?php echo $value; ?>')">
							<?php echo GetMessage($value); ?>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<div v-if="currentTab=='DETAILS'" class="p-2">
			<pre><?php print_r($arResult); ?></pre>
		</div>
		<div v-if="currentTab=='FAQ'" class="p-2">
			faq
		</div>
		<div v-if="currentTab=='SUPPORT'" class="p-2">
			support
		</div>
	</div>
</div>

<script>
	BX.Vue.create({
		el: '#deal_detail',
		data: {
			currentTab: 'DETAILS',
		},
		methods: {
			setCurrentTab: function (tab) {
				this.currentTab = tab;
			},
			isActiveTab: function (tab) {
				if (tab == this.currentTab) {
					return 'active';
				}
				return '';
			}
		},

	});
</script>