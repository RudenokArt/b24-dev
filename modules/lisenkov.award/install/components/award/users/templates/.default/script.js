;(function () {

    BX.namespace('BX.Award.Users');

	BX.addCustomEvent('onPullEvent-lisenkov.award', BX.delegate(function (command, params) {

		if (command === 'APPLY_FILTER') {

			BX.Award.Users.DATE_from = params.DATE_from;
			BX.Award.Users.DATE_to = params.DATE_to;
			BX.Award.Users.SORT = params.SORT;
			BX.Award.Users.FILTER_DATA = params.FILTER_DATA;
			
		}

	}, this));

    BX.Award.Users.ShowDetail = function (userId) {

		BX.SidePanel.Instance.open(

			'slider.php?userId=' + userId + '&filter=' + JSON.stringify({
				dateFrom: BX.Award.Users.DATE_from,
				dateTo: BX.Award.Users.DATE_to
			}), {

				width: 1200,
	            cacheable: false,
	            allowChangeHistory: false,
	            animationDuration: 200,
	            label: {
	                color: "#FFFFFF",
	                bgColor: "#000000",
	                opacity: 0
	            }

			}

		);

	}


	BX.Award.Users.UpdateRows = function () {

	    for(var i = 2; i < BX.Award.Users.Grid.rows.rows.length; i++) {

			BX.Award.Users.Grid.rows.rows[i].node.style.cursor = 'help';

	        BX.Award.Users.Grid.rows.rows[i].node.onclick = function () {

	            BX.Award.Users.ShowDetail(this.dataset.id);

			}

	    }

	}

	BX.Award.Users.CreateReport = function (btn) {

		if (BX.Award.Users.ajaxIsAllowed) {

			btn.button.classList.add('ui-btn-clock');
			BX.Award.Users.ajaxIsAllowed = false;

			BX.ajax.runComponentAction('award:users', 'buildExcel', {

				data: {

					sort: BX.Award.Users.SORT,
					filterData: BX.Award.Users.FILTER_DATA

				}

			}).then(function (response) {

				BX.addCustomEvent('onPullEvent-lisenkov.pdfconverter', BX.delegate(function (command, params) {

					if (command === 'file-conversion-' + response.data.fileId) {

						BX.ajax.runComponentAction('award:users', 'saveToDisk', {

							data: {

								pdfId: params.pdf.id,
								jpgId: params.preview.id,
								name: response.data.name
							}

						}).then(function (response2) {

							btn.button.classList.remove('ui-btn-clock');
							BX.Award.Users.ajaxIsAllowed = true;

							var filter = {
								dateFrom: BX.Award.Users.DATE_from,
								dateTo: BX.Award.Users.DATE_to
							}

							BX.SidePanel.Instance.open(

								'slider.php?excel=' + response.data.id + '&pdf=' + response2.data.pdf + '&jpg=' + response2.data.jpg + '&filter=' + JSON.stringify({
									dateFrom: BX.Award.Users.DATE_from,
									dateTo: BX.Award.Users.DATE_to
								}), {

									width: 1200,
									cacheable: false,
									allowChangeHistory: false,
									animationDuration: 200,
									label: {
										color: "#FFFFFF",
										bgColor: "#000000",
										opacity: 0
									}

								}

							);

						});

					}

				}, this));

				BX.ajax.runComponentAction('award:users', 'convertToPdf', {

					data: {

						fileId: response.data.fileId

					}

				});

			});

		}

	}

})();