<?php

namespace AppBundle\Service\BinhLe\ThieuNhi;

use AppBundle\Entity\BinhLe\ThieuNhi\BangDiem;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Service\BaseService;
use AppBundle\Service\SpreadsheetWriter;

class ThanhVienService extends BaseService {
	
	public function writeBangDiemDoiNhomGiaoLyHK1Data(SpreadsheetWriter $sWriter, PhanBo $phanBo) {
		$style1 = array(
			'font'      => array(
				'bold'  => true,
				'color' => array( 'rgb' => 'FFFFFF' ),
				'size'  => 12,
				'name'  => 'Times New Roman'
			)
		,
			'alignment' => array(
				'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->getCurrentRowDimension()->setRowHeight(20);
		$sWriter->mergeCellsDown(2);
		$sWriter->writeCellAndGoRight('MÃ SỐ');
		
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->mergeCellsDown(2);
		$sWriter->writeCellAndGoRight('TÊN THÁNH');
		
		
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->mergeCellsDown(2);
		$sWriter->writeCellAndGoRight('HỌ');
		
		
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->mergeCellsDown(2);
		$sWriter->writeCellAndGoRight('TÊN');
		
		
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->mergeCellsRightDown(3, 1);
		$sWriter->writeCell('CHUYÊN CẦN');
		
		$sWriter->goDown(2);
		
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->writeCellAndGoRight(' T9 ');
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->writeCellAndGoRight(' T10 ');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->writeCellAndGoRight(' T11 ');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->setCurrentCellColor('FF9900');
		$sWriter->writeCellAndGoRight(' T12 ');
		
		$sWriter->goUp(2);
		
		$sWriter->setCurrentCellColor('0000FF');
		$sWriter->getCurrentCellStyle()->applyFromArray($style1);
		$sWriter->mergeCellsDown(2);
		$sWriter->getCurrentColumnDimension()->setAutoSize(false);
		$sWriter->getCurrentColumnDimension()->setWidth(20);
		$sWriter->writeCellAndGoRight('TB.CHUYÊN CẦN');
		
		$sWriter->goDown(2);
		//////////////// Write Names and Code
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($phanBo->getCacTruongPhuTrachDoi() as $truongPT) {
			$phanBoHangNam = $truongPT->getDoiNhomGiaoLy()->getPhanBoHangNam();
			/** @var PhanBo $phanBo */
			foreach($phanBoHangNam as $phanBo) {
				$sWriter->goDown();
				$sWriter->goFirstColumn();
				$thanhVien = $phanBo->getThanhVien();
				if(empty($bangDiem = $phanBo->getBangDiem())) {
					$phanBo->setBangDiem($bangDiem = new BangDiem());
				}
				
				$sWriter->writeCellAndGoRight('  ' . $thanhVien->getCode() . '  ');
				$sWriter->writeCellAndGoRight('  ' . $thanhVien->getChristianname() . '  ');
				$sWriter->writeCellAndGoRight('  ' . $thanhVien->getLastname() . ' ' . $thanhVien->getMiddlename() . '  ');
				$sWriter->writeCellAndGoRight('  ' . $thanhVien->getFirstname() . '  ');
				$sWriter->writeCellAndGoRight($bangDiem->getCc9());
				$sWriter->writeCellAndGoRight($bangDiem->getCc10());
				$sWriter->writeCellAndGoRight($bangDiem->getCc11());
				$sWriter->writeCellAndGoRight($bangDiem->getCc12());
				$sWriter->alignCurrentCellCenter();
				$sWriter->writeCellAndGoRight(sprintf('=ROUND(SUM(E%1$d:H%1$d)/4,2)', $sWriter->getCursorRow()));
				
			}
		}
		
		
		$sWriter->getCellsStyle('A5', 'N' . $sWriter->getLastRow())->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => \PHPExcel_Style_Border::BORDER_THIN
					)
				)
			));
		
		
	}
}