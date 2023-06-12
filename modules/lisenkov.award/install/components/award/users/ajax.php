<?php
use Bitrix\Main\Loader,
	PhpOffice\PhpSpreadsheet\IOFactory,
	PhpOffice\PhpSpreadsheet\Writer\Xlsx,
	PhpOffice\PhpSpreadsheet\Style\Alignment;

class AwardUsersAjaxController extends Bitrix\Main\Engine\Controller {

	public function buildExcelAction($sort, $filterData = false) {

		Loader::IncludeModule('lisenkov.award');
		if (!Loader::IncludeModule('lisenkov.phpoffice')) die;

		CBitrixComponent::includeComponentClass('award:users');

		$awardUsersComponent = new AwardUsersComponent;

		$awardUsersComponent->setFilter($filterData, $sort, false);
		$users = $awardUsersComponent->getUsers(true);

		$url = Bitrix\Main\Engine\UrlManager::getHostUrl();
		$baseCurrency = CCurrency::getBaseCurrency();

		$filter = [
				'USER_ID' => array_keys($users),
				'><DATE' => $awardUsersComponent->date
			];

			if ($filterData['deal']) {
				$filter['TASK'] = $awardUsersComponent->awardDealFilter($filterData['deal']);
			}

		$awards = Bitrix\Lisenkov\AwardTable::getList([
			'filter' => $filter,
		])->fetchAll();

		foreach ($awards as $award) {
			$uAwards[$award['USER_ID']][] = $award;
		}

		$categories = Bitrix\Crm\Category\DealCategory::getAll(true);

		$spreadsheet = IOFactory::load(__DIR__ . '/excel/template.xlsx');
		$sheet = $spreadsheet->getActiveSheet();

		$sum = 0;
		$row = 10;
		foreach ($users as $id => $user) {

			if (array_key_exists($id, $uAwards)) {

				foreach ($uAwards[$id] as $award) {

					$doc = new DOMDocument;
					$doc->loadHTML('<?xml encoding="UTF-8">' . $award['TASK']);
					$link = $doc->getElementsByTagName('a')[0];

					$taskId = end(explode('/', substr($link->getAttribute('href'), 1, -1)));

					$sheet->setCellValue('B' . $row, $user);

					if ($dealId = current(CTasks::getList([], ['=ID' => $taskId, 'CHECK_PERMISSIONS' => 'N'], ['UF_CRM_TASK'])->fetch()['UF_CRM_TASK'])) {

						$dealId = substr($dealId, 2);

						$sheet->setCellValue('C' . $row, $dealId);

						$deal = CCrmDeal::getList([], ['=ID' => $dealId, 'CHECK_PERMISSIONS' => 'N'])->fetch();

						$sheet->setCellValue('D' . $row, $deal['TITLE']);
						$sheet->setCellValue('E' . $row, html_entity_decode(currencyFormat($deal['OPPORTUNITY'],  $deal['CURRENCY_ID'])));
						$sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
						$payedPart = explode('|', $deal['UF_CRM_1676980067227']);
						$sheet->setCellValue('F' . $row, html_entity_decode(CurrencyFormat(array_shift($payedPart),  array_shift($payedPart))));
						$sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
						$sheet->setCellValue('G' . $row, $deal['UF_CRM_1573037187764']);

						$stage = Bitrix\Crm\StatusTable::getList([
							'select' => ['CATEGORY_ID', 'NAME'],
							'filter' => ['STATUS_ID' => $deal['STAGE_ID']]
						])->fetch();

						foreach ($categories as $category) {

							if ((int) $category['ID'] === (int) $stage['CATEGORY_ID']) {

								$sheet->setCellValue('H' . $row, $category['NAME'] . ': ' . $stage['NAME']);
								break;

							}

						}

					}

					$sheet->setCellValue('I' . $row, $link->textContent);
					$sheet->getCell('I' . $row)->getHyperlink()->setUrl($url . $link->getAttribute('href'));
					$sheet->setCellValue('J' . $row, $award['DATE']);
					$sheet->setCellValue('K' . $row, html_entity_decode($award['AWARD']));
					$sheet->getStyle('k' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

					$sum += $award['AWARD']->getConvertedAmount($baseCurrency);

					$row++;

					$sheet->insertNewRowBefore($row, 1);

				}

			}

		}

		$sheet->removeRow($row);

		$sheet->setCellValue('K2', $awardUsersComponent->date ? new Bitrix\Main\Type\Date($awardUsersComponent->date[0]) . ' - ' . new Bitrix\Main\Type\Date($awardUsersComponent->date[1]) : 'за все время');
		$sheet->setCellValue('K3', html_entity_decode(CurrencyFormat($sum,  $baseCurrency)));
		$sheet->getStyle('K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		foreach (range('B', $sheet->getHighestDataColumn()) as $col) {

			$sheet->getColumnDimension($col)->setAutoSize(true);

		}

		$writer = new Xlsx($spreadsheet);
		$excel = __DIR__ . '/excel/' . getMessage('AWARD_USERS_AJAX_FILE', ['#RAND#' => Bitrix\Main\Security\Random::getInt()]) . '.xlsx';
		$writer->save($excel);

		$storage = Bitrix\Disk\Driver::getInstance()->getStorageByCommonId('shared_files_s1');

		$folder = $storage->getChild([
			'=NAME' => getMessage('AWARD_USERS_AJAX_FOLDER'),
			'TYPE' => Bitrix\Disk\Internals\FolderTable::TYPE_FOLDER
		]);

		if (!$folder) $folder = $storage->addFolder(['NAME' => getMessage('AWARD_USERS_AJAX_FOLDER')]);

		$fileArray = CFile::makeFileArray($excel);
		$file = $folder->uploadFile($fileArray, ['CREATED_BY' => $GLOBALS['USER']->getId()]);

		unlink($excel);

		return [
			'id' => $file->getId(),
			'fileId' => $file->getFileId(),
			'name' => strstr($file->getName(), '.', true),
			'filter' => $filterData['deal'],
		];

	}

	public function convertToPdfAction($fileId) {

		return PDFConverter::convert($fileId, true);

	}

	public function saveToDiskAction($pdfId, $jpgId, $name) {

		$storage = Bitrix\Disk\Driver::getInstance()->getStorageByCommonId('shared_files_s1');

		$folder = $storage->getChild([
			'=NAME' => getMessage('AWARD_USERS_AJAX_FOLDER'),
			'TYPE' => Bitrix\Disk\Internals\FolderTable::TYPE_FOLDER
		]);

		if (!$folder) $folder = $storage->addFolder(['NAME' => getMessage('AWARD_USERS_AJAX_FOLDER')]);

		$fileArray = CFile::makeFileArray($pdfId);
		$pdf = $folder->uploadFile($fileArray, ['CREATED_BY' => $GLOBALS['USER']->getId(), 'NAME' => $name . '.pdf']);

		$fileArray = CFile::makeFileArray($jpgId);
		$jpg = $folder->uploadFile($fileArray, ['CREATED_BY' => $GLOBALS['USER']->getId(), 'NAME' => $name . '.jpg']);

		return ['pdf' => $pdf->getId(), 'jpg' => $jpg->getId()];

	}

}
?>