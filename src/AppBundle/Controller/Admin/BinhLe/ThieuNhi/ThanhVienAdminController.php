<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Service\SpreadsheetWriter;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThanhVienAdminController extends BaseCRUDController {
	
	public function truongChiDoanAction(ChiDoan $chiDoan, Request $request) {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('truong-chi-doan');
		$admin->setActionParams([ 'chiDoan' => $chiDoan ]);
		
		return parent::listAction();
	}
	
	public function thieuNhiNhomAction(PhanBo $phanBo, Request $request) {
		$cacTruongPT      = $phanBo->getCacTruongPhuTrachDoi();
		$cacDoiNhomGiaoLy = [];
		
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($cacTruongPT as $truongPT) {
			$cacDoiNhomGiaoLy [] = $truongPT->getDoiNhomGiaoLy();
		}
		
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('list-thieu-nhi-nhom');
		$admin->setActionParams([
			'phanBo'           => $phanBo,
			'cacDoiNhomGiaoLy' => $cacDoiNhomGiaoLy,
			'chiDoan'          => $phanBo->getChiDoan()
		]);
		
		return parent::listAction();
	}
	
	public function thieuNhiNhomDownloadBangDiemAction(PhanBo $phanBo, $hocKy, Request $request) {
//		\PHPExcel_Shared_Font::setAutoSizeMethod(\PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		
		$thanhVienService = $this->get('app.binhle_thieunhi_thanhvien');
		$filename         = 'bang-diem-hk1.xlsx';
//		$response = new BinaryFileResponse($zipFile);
//		$response->headers->set('Content-Disposition', 'attachment;filename=' . str_replace(' ', '-', 'ihp_export_' . $dateAlnum . '.zip'));
		$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
		
		$phpExcelObject->getProperties()->setCreator("Solution")
		               ->setLastModifiedBy("Solution")
		               ->setTitle("Download - Raw Data")
		               ->setSubject("Bang Diem HK1")
		               ->setDescription("Raw Data")
		               ->setKeywords("office 2005 openxml php")
		               ->setCategory("Raw Data Download");
		
		$phpExcelObject->setActiveSheetIndex(0);
		$activeSheet = $phpExcelObject->getActiveSheet();
		
		$activeSheet->setCellValue('A1', "BẢNG ĐIỂM HỌC KỲ 1");
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$phpExcelObject->setActiveSheetIndex(0);
		$activeSheet = $phpExcelObject->getActiveSheet();
		$sWriter     = new SpreadsheetWriter($activeSheet);
		$sWriter->mergeCellsRight(13);
		$sWriter->getCurrentCellStyle()->applyFromArray(array(
			'font'      => array(
				'bold' => true,
//				'color' => array( 'rgb' => 'FF0000' ),
				'size' => 18,
				'name' => 'Times New Roman'
			)
		,
			'alignment' => array(
				'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		));
		
		$sWriter->getCurrentRowDimension()->setRowHeight(30);
		$sWriter->goDown();
		$sWriter->writeCell(sprintf('NĂM HỌC %d - %d', $phanBo->getNamHoc()->getId(), $phanBo->getNamHoc()->getId() + 1));
		$sWriter->mergeCellsRight(13);
		$sWriter->getCurrentCellStyle()->applyFromArray(array(
			'font'      => array(
				'bold' => true,
//				'color' => array( 'rgb' => 'FF0000' ),
				'size' => 15,
				'name' => 'Times New Roman'
			)
		,
			'alignment' => array(
				'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		));
		$sWriter->getCurrentRowDimension()->setRowHeight(25);
		$sWriter->goDown();
		$sWriter->writeCell(sprintf('CHI ĐOÀN: %d', $phanBo->getChiDoan()->getNumber()));
		$sWriter->mergeCellsRight(13);
		$sWriter->getCurrentCellStyle()->applyFromArray(array(
			'font'      => array(
				'bold' => true,
//				'color' => array( 'rgb' => 'FF0000' ),
				'size' => 15,
				'name' => 'Times New Roman'
			)
		,
			'alignment' => array(
				'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		));
		$sWriter->getCurrentRowDimension()->setRowHeight(25);
		$sWriter->goDown();
		$sWriter->goDown();
		
		foreach(range('A', 'N') as $columnID) {
			$activeSheet->getColumnDimension($columnID)
			            ->setAutoSize(true);
		}
		
		$thanhVienService->writeBangDiemDoiNhomGiaoLyHK1Data($sWriter, $phanBo);

//		$colDimensions = $activeSheet->getColumnDimensions();
//		foreach($colDimensions as $dimension) {
//			$dimension->setAutoSize(true);
//		}
		
		$activeSheet->calculateColumnWidths();
		// create the writer
		$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
		// create the response
		$response = $this->get('phpexcel')->createStreamedResponse($writer);
		$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
		$response->headers->set('Pragma', 'public');
		$response->headers->set('Cache-Control', 'maxage=1');
		
		$response->headers->set('Content-Disposition', 'attachment;filename=' . $filename);
		
		return $response;
	}
	
	
	public function thieuNhiAction(Request $request) {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('list-thieu-nhi');
		
		return parent::listAction();
	}
	
}