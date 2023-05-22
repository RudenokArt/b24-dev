;(function () {

    BX.namespace('BX.Award.Report');

	BX.Award.Report.SelectType = function (choise, item) {

	    item.popupWindow.close();

		switch (choise) {
			case 'OPEN_PDF':
				BX.Award.Report.OpenReport(BX.message('PDF_AJAX_CONTROLLER'));
			break;
			case 'OPEN_EXCEL':
				BX.Award.Report.OpenReport(BX.message('EXCEL_AJAX_CONTROLLER'));
			break;
			case 'DOWNLOAD_PDF':
				BX.Award.Report.Download(BX.message('PDF_FILE_ID'), BX.message('PDF_FILE_NAME'));
			break;
			case 'DOWNLOAD_EXCEL':
				BX.Award.Report.Download(BX.message('EXCEL_FILE_ID'), BX.message('EXCEL_FILE_NAME'));
			break;
			case 'OPEN_ON_DISK_PDF':
				BX.Award.Report.ShowDetails(BX.message('PDF_PATH_FILE_DETAIL'));
			break;
			case 'OPEN_ON_DISK_EXCEL':
				BX.Award.Report.ShowDetails(BX.message('EXCEL_PATH_FILE_DETAIL'));
			break;
		}

	}

	BX.Award.Report.OpenReport = function (ajaxController) {

		BX.SidePanel.Instance.open(

			ajaxController, {

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

	BX.Award.Report.Download = function (fileId, fileName) {

		BX.ajax.runComponentAction('award:report', 'generateDownloadLink', {

			data: {

				fileId: fileId,
				fileName: fileName

			}

		}).then(function (response) {

			window.open(response.data, '_self')

		});

	}

	BX.Award.Report.ShowDetails = function (pathFileDetail) {

		BX.SidePanel.Instance.open(

			pathFileDetail, {

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

})();