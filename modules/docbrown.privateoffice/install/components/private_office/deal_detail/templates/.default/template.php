<div class="container pt-5 mt-5 pb-5 deal_detail-container" id="deal_detail">
	<div class="row text-secondary pb-5 bg-light">
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
				<?php endif ?> class="deal_detail-status_item p-1 mt-1 border">
				<?php echo $value['NAME']; ?>
			</div>
			<?php if ($value['STATUS_ID'] == $arResult['deal']['STAGE_ID']): ?>
				<?php $deal_detail_status_flag = false; ?>
			<?php endif ?>
		<?php endforeach ?>
	</div>
</div>

<div class="card p-1 mt-5">
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
		<div class="row">
			<?php foreach ($arResult['deal'] as $key => $value): ?>
				<div class="col-lg-6 col-md-12 col-sm-12">

					<div class="input-group mb-3">
						<span class="input-group-text bg-light w-50" id="basic-addon<?php echo $key ?>"><?php echo $arResult['deal_fields'][$key]['title']; ?></span>
						<input type="text" class="form-control" value="<?php echo $value; ?>" aria-describedby="basic-addon<?php echo $key ?>" disabled>
					</div>

					
				</div>
			<?php endforeach ?>
		</div>		
	</div>
	<div v-if="currentTab=='FAQ'" class="p-2">

		<div class="accordion" id="accordionFAQ">
			<?php foreach ($arResult['FAQ_list'] as $key => $value): ?>
				<div class="card">
					<div class="card-header" id="heading-<?php echo $value['ID'];?>">
						<h5 class="mb-0">
							<button class="btn btn-ounline-success" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $value['ID'];?>" aria-expanded="true" aria-controls="collapse-<?php echo $value['ID'];?>">
								<b class="text-secondary"><?php echo $value['NAME']; ?></b>
								<?php echo $value['PREVIEW_TEXT']; ?>
							</button>
						</h5>
					</div>
					<div id="collapse-<?php echo $value['ID'];?>" class="collapse" aria-labelledby="heading-<?php echo $value['ID'];?>" data-parent="#accordionFAQ">
						<div class="card-body">
							<?php echo $value['DETAIL_TEXT']; ?>
						</div>
					</div>
				</div>
			<?php endforeach ?>		
		</div>

	</div>

	<div v-if="currentTab=='SUPPORT'" class="p-2">

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			<?php echo GetMessage('Add_new_case') ?>
		</button>
		<div class="pt-5">
			<div v-for="(item, index) in ticketsList" class="row border-bottom">
				<div class="col-lg-1 col-md-2 col-sm-4">
					{{item.ID}}
				</div>
				<div class="col-lg-8 col-md-6 col-sm-8" v-html="item.DESCRIPTION"></div>
				<div class="col-lg-3 col-md-4 col-sm-12 text-primary">
					<span v-for="item1 in [1, 2, 3, 4, 5, 6]">
						<span v-if="item.STATUS >= item1" v-bind:title="ticketTaskStatuses[item1]">
							<i class="fa fa-square" aria-hidden="true"></i>
						</span>
						<span v-else="item.STATUS < item1" v-bind:title="ticketTaskStatuses[item1]">
							<i class="fa fa-square-o" aria-hidden="true"></i>
						</span>  
					</span>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					<?php echo GetMessage('Add_new_case') ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" class="row"  v-on:submit.prevent="addNewCase">
					<div class="col-12 pt-1"><div class="pt-2 pb-2">
						<?php echo GetMessage('service_reason'); ?>
						<select v-model="reason" class="form-select" required>
							<option></option>
							<option><?php echo GetMessage('warranty_case'); ?></option>
							<option><?php echo GetMessage('claim'); ?></option>
						</select>
					</div>
					<div class="pt-2 pb-2">
						<?php echo GetMessage('priority'); ?>: 
						<select v-model="priority" class="form-select" required>
							<option></option>
							<option><?php echo GetMessage('critical_disorder'); ?></option>
							<option><?php echo GetMessage('Disturbance'); ?></option>
							<option><?php echo GetMessage('insignificant_disturbance'); ?></option>
						</select>
					</div>
					<div class="pt-2 pb-2">
						<?php echo GetMessage('remark'); ?>:
						<textarea v-model="remark" class="form-control" required></textarea>
					</div>
					<div class="pt-2 pb-2" style="height:100px">
						<div v-if="preloader" class="text-primary text-center">
							<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						</div>								
						<button v-else="!preloader" class="btn btn-primary w-100">
							<?php echo GetMessage('SEND') ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>

</div>

<script>
	var dealDetail = BX.Vue.create({
		el: '#deal_detail',
		data: {
			currentTab: 'DETAILS',
			ajaxUrl: "<?php echo $this->getComponent()->getPath().'/ajax.php';?>",
			deal_id: "<?php echo $arResult['deal']['ID'] ?>",
			reason: '',
			priority: '',
			remark: '',
			preloader: false,
			ticketsList: [],
			ticketTaskStatuses: [
				'New',
				'Accepted',
				'Performed',
				'Under Control',
				'Completed',
				'Postponed',
				],
		},

		mounted: function () {
			this.getTicketsList();
		},

		methods: {
			addNewCase: async function () {
				this.preloader = true;
				await $.post(this.ajaxUrl, {
					add: 'Y',
					reason: this.reason,
					priority: this.priority,
					remark: this.remark,
					deal: this.deal_id,
					responsible: "<?php echo $arResult['deal']['ASSIGNED_BY_ID']; ?>",
				}, function (data) {
					console.log(data);
				});
				await this.getTicketsList();
				this.preloader = false;
			},

			getTicketsList: async function () {
				var json = await $.post(this.ajaxUrl, {
					getList: 'Y',
					deal: this.deal_id,
				}, function (data) {});
				console.log(this.ticketsList);
				this.ticketsList = JSON.parse(json);
				$('button[data-dismiss="modal"]').click();
			},

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
<pre class="bg-light" style="margin-top: 50vh"><?php print_r($arResult['deal']); ?></pre>