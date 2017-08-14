<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\BangDiemAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\BangDiem;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\NamHoc;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BangDiemAdminController extends BaseCRUDController {
	
	public function listAction() {
		/** @var BangDiemAdmin $admin */
		$admin = $this->admin;
		
		$repo        = $this->getDoctrine()->getRepository(NamHoc::class);
		$namHocArray = $repo->findBy(
			array( 'enabled' => true ),
			array( 'id' => 'DESC' ),
			1
		);
		$namHoc      = null;
		if(count($namHocArray) > 0) {
			$namHoc = $namHocArray[0];
			$admin->setNamHoc($namHoc->getId());
		}
		
		return parent::listAction();
	}
	
	public
	function bangDiemImportAction(
		$namHoc, Request $request
	) {
		if(empty($namHoc)) {
			throw new NotFoundHttpException();
		}
		
		$manager = $this->get('doctrine.orm.entity_manager');
		if($request->isMethod('post')) {
			$fileFieldName = 'bang-diem';
			if(isset($_FILES[ $fileFieldName ])) {
				$errors           = array();
				$file_name        = $_FILES[ $fileFieldName ]['name'];
				$file_size        = $_FILES[ $fileFieldName ]['size'];
				$file_tmp         = $_FILES[ $fileFieldName ]['tmp_name'];
				$file_type        = $_FILES[ $fileFieldName ]['type'];
				$explodedFileName = explode('.', $_FILES[ $fileFieldName ]['name']);
				$file_ext         = strtolower(end($explodedFileName));
				
				$filePath = $this->getParameter(
						'kernel.root_dir'
					) . '/../web/import/binhle/bang-diem-thieu-nhi-' . $namHoc . '_' . $file_name;
				
				file_exists($filePath) ? unlink($filePath) : "";
				
				$expensions = array( "xls", "xlsx" );
				
				if(in_array($file_ext, $expensions) === false) {
					$errors[] = "Extension not allowed, please choose a valid Microsoft Excel file.";
				}
				
				if($file_size > 2097152) {
					$errors[] = 'File size must be less than 2 MB';
				}
				
				if(empty($errors) == true) {
					move_uploaded_file($file_tmp, $filePath);
				} else {
					$this->addFlash('sonata_flash_error', implode(', ', $errors));
				}

//				$action = 'processImportedList';
//            } else {
//				$action      = 'done';
//				$conn        = $this->get('database_connection');
//				$updateQuery = 'UPDATE `mhs__employer__employee` SET `state` = \'' . BusinessEmployee::STATE_DRAFT . '\' WHERE `mhs__employer__employee`.`id` = ' . $id;
//                $conn->update('mhs__employer__employee', array('state' => BusinessEmployee::STATE_DRAFT), array('id_employer' => $id, 'enabled' => true));
				
				$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($filePath);
				$row            = 5;
				$successfulRow  = 0;
				
				while(true) {
					$_lname = $phpExcelObject->getActiveSheet()->getCell('C' . $row)->getValue();
					if(empty($_lname)) {
						break;
					}
					$_cname    = $phpExcelObject->getActiveSheet()->getCell('B' . $row)->getValue();
					$_mname    = $phpExcelObject->getActiveSheet()->getCell('D' . $row)->getValue();
					$_qname    = $phpExcelObject->getActiveSheet()->getCell('E' . $row)->getValue();
					$_fname    = $phpExcelObject->getActiveSheet()->getCell('F' . $row)->getValue();
					$_idNumber = trim($phpExcelObject->getActiveSheet()->getCell('A' . $row)->getValue());
					
					$_cc1 = (trim($phpExcelObject->getActiveSheet()->getCell('G' . $row)->getValue()));
					$_cc2 = (trim($phpExcelObject->getActiveSheet()->getCell('H' . $row)->getValue()));
					$_cc3 = (trim($phpExcelObject->getActiveSheet()->getCell('I' . $row)->getValue()));
					$_cc4 = (trim($phpExcelObject->getActiveSheet()->getCell('J' . $row)->getValue()));
					$_cc5 = (trim($phpExcelObject->getActiveSheet()->getCell('K' . $row)->getValue()));
					
					$_tbCCTerm2  = (trim($phpExcelObject->getActiveSheet()->getCell('L' . $row)->getOldCalculatedValue()));
					$_quizTerm2  = (trim($phpExcelObject->getActiveSheet()->getCell('M' . $row)->getValue()));
					$_midTerm2   = (trim($phpExcelObject->getActiveSheet()->getCell('N' . $row)->getValue()));
					$_finalTerm2 = (trim($phpExcelObject->getActiveSheet()->getCell('O' . $row)->getValue()));
					
					$_tbTerm1 = (trim($phpExcelObject->getActiveSheet()->getCell('P' . $row)->getOldCalculatedValue()));
					$_tbTerm2 = (trim($phpExcelObject->getActiveSheet()->getCell('Q' . $row)->getOldCalculatedValue()));
					$_phieuLe = (trim($phpExcelObject->getActiveSheet()->getCell('R' . $row)->getValue()));
					
					$_tbYear    = (trim($phpExcelObject->getActiveSheet()->getCell('T' . $row)->getOldCalculatedValue()));
					$_category  = (trim($phpExcelObject->getActiveSheet()->getCell('U' . $row)->getOldCalculatedValue()));
					$_retention = (trim($phpExcelObject->getActiveSheet()->getCell('V' . $row)->getOldCalculatedValue()));
					$_awarded   = (trim($phpExcelObject->getActiveSheet()->getCell('W' . $row)->getOldCalculatedValue()));
					$_chiDoan   = (trim($phpExcelObject->getActiveSheet()->getCell('X' . $row)->getValue()));


//					$_dobCell     = $phpExcelObject->getActiveSheet()->getCell('F' . $row);
//					$_dobString   = $_dobCell->getValue();

//					if(\PHPExcel_Shared_Date::isDateTime($_dobCell)) {
//						$_dob = new \DateTime('@' . \PHPExcel_Shared_Date::ExcelToPHP($_dobString));
//					} elseif( ! empty($_dobString)) {
//						$_dob = \DateTime::createFromFormat('d/m/Y', $_dobString);
//					}

//					$_gender = $phpExcelObject->getActiveSheet()->getCell('G' . $row)->getValue();
//					if(strtoupper($_gender) === 'MALE') {
//						$_gender = 'Male';
//					}

//					if(strtoupper($_gender) === 'FEMALE') {
//						$_gender = 'Female';
//					}
//					if( ! in_array($_gender, [ 'Male', 'Female' ])) {
//						$_gender = null;
//					}

//					$email = $phpExcelObject->getActiveSheet()->getCell('H' . $row)->getValue();
					
					
					$bangDiem = new BangDiem();
					$bangDiem->setSundayTickets(intval($_phieuLe));
					$bangDiem->setAwarded(($_awarded === 'X'));
					$bangDiem->setGradeRetention($_retention === 'Ở LẠI');
					
					switch($_category) {
						case 'KHÁ':
							$_category = BangDiem::KHA;
							break;
						case 'GIỎI':
							$_category = BangDiem::GIOI;
							break;
						case 'TRUNG BÌNH':
							$_category = BangDiem::TRUNG_BINH;
							break;
						case 'YẾU':
							$_category = BangDiem::YEU;
							break;
					}
					$bangDiem->setCategory($_category);
					$bangDiem->setCc1(intval($_cc1));
					$bangDiem->setCc2(intval($_cc2));
					$bangDiem->setCc3(intval($_cc3));
					$bangDiem->setCc4(intval($_cc4));
					$bangDiem->setCc5(intval($_cc5));
					$bangDiem->setTbCCTerm2(floatval($_tbCCTerm2));
					$bangDiem->setQuizTerm2(floatval($_quizTerm2));
					$bangDiem->setMidTerm2(floatval($_midTerm2));
					$bangDiem->setFinalTerm2(floatval($_finalTerm2));
					
					$bangDiem->setTbTerm2(floatval($_tbTerm2));
					$bangDiem->setTbTerm1(floatval($_tbTerm1));
					
					$bangDiem->setTbYear(floatval($_tbYear));
					
					$thanhVien = new ThanhVien();
					$thanhVien->setFirstname($_fname);
					$thanhVien->setLastname($_lname);
					$thanhVien->setMiddlename($_mname);
					$thanhVien->setApproved(true);
					
					$thanhVien->setQuickName($_qname);
					$thanhVien->setChristianname($_cname);
					$thanhVien->setName($_cname . ' ' . $_lname . ' ' . $_mname . ' ' . $_fname);
					$thanhVien->setThieuNhi(true);
					$thanhVien->setHuynhTruong(false);
					$thanhVien->setChiDoan($_chiDoan);
					$thanhVien->setPhanDoan(ThanhVien::$danhSachChiDoan[ intval($_chiDoan) ]);
					$thanhVien->setNamHoc(intval($namHoc));
					
					if($_idNumber === 'xxx') {
						$thanhVien->setEnabled(false);
					} else {
						$thanhVien->setEnabled(true);
					}
					
					
					$chiDoanRepo = $this->getDoctrine()->getRepository(ChiDoan::class);
					$namHocRepo  = $this->getDoctrine()->getRepository(NamHoc::class);
					$namHocObj   = $namHocRepo->find($namHoc);
					$chiDoan     = $chiDoanRepo->findOneBy([ 'namHoc' => $namHoc, 'name' => ($_chiDoan) ]);
					if(empty($chiDoan)) {
						$chiDoan = new ChiDoan();
						$chiDoan->setNamHoc($namHocObj);
						$chiDoan->setPhanDoan(ThanhVien::$danhSachChiDoan[ intval($_chiDoan) ]);
						$chiDoan->setName(($_chiDoan));
						$chiDoan->generateId();
						$manager->persist($chiDoan);
						$manager->flush($chiDoan);
					}
					
					$phanBo = new PhanBo();
					$phanBo->setPhanDoan(ThanhVien::$danhSachChiDoan[ intval($_chiDoan) ]);
					$phanBo->setChiDoan($chiDoan);
					$phanBo->setThanhVien($thanhVien);
					$bangDiem->setPhanBo($phanBo);
					
					$phanBo->setHuynhTruong(false);
					$phanBo->setThieuNhi(true);
					
					
					$successfulRow ++;
					$manager->persist($bangDiem);
					$manager->persist($phanBo);
					$manager->persist($chiDoan);
					$manager->persist($thanhVien);
					$row ++;
				}
				try {
					$manager->flush();

//                    $employeeArray = $conn->fetchAll('SELECT * FROM mhs__employer__employee WHERE state LIKE \'' . BusinessEmployee::STATE_DRAFT . '\' AND id_employer = ' . $id);
//                    $resigneeCount = 0;
//                    if (count($employeeArray) > 0) {
//                        foreach ($employeeArray as $_employee) {
//                            $conn->update('mhs__employer__employee', array('enabled' => false, 'state' => BusinessEmployee::STATE_PUBLISHED), array('id' => $_employee['id']));
//                            $resigneeCount++;
//                        }
//                    }
					
					$this->addFlash('sonata_flash_success', sprintf("%s employee(s) has/have been imported.", $successfulRow - 2));
					
				} catch(\Exception $exception) {
					$this->addFlash('sonata_flash_error', $exception->getMessage());
				}
				unlink($filePath);
			}
		}
		
		return new RedirectResponse($this->generateUrl('admin_app_binhle_thieunhi_bangdiem_list', [
		
		]));
	}
	
	
}