<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\NamHoc;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Entity\User\User;
use AppBundle\Service\SpreadsheetWriter;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThanhVienAdminController extends BaseCRUDController {
	
	public function truongChiDoanAction(ChiDoan $chiDoan, Request $request) {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('truong-chi-doan');
		$admin->setActionParams([ 'chiDoan' => $chiDoan ]);
		if( ! empty($namHoc = $this->get('app.binhle_thieunhi_namhoc')->getNamHocHienTai())) {
			$admin->setNamHoc($namHoc->getId());
		}
		return parent::listAction();
	}
	
	public function thieuNhiAction(Request $request) {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		$admin->setAction('list-thieu-nhi');
		
		return parent::listAction();
	}
	
	
	public
	function importAction(
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
				$thanhVienRepo  = $this->getDoctrine()->getRepository(ThanhVien::class);
				$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($filePath);
				$row            = 2;
				$successfulRow  = 0;
				
				while(true) {
					$_lname = $phpExcelObject->getActiveSheet()->getCell('C' . $row)->getValue();
					if(empty($_lname)) {
						break;
					}
					$_lname = mb_strtoupper(trim($_lname));
					
					$_cname = $phpExcelObject->getActiveSheet()->getCell('B' . $row)->getValue();
					if( ! empty($_cname)) {
						$_cname = trim($_cname);
						if( ! empty($_cname)) {
//							$_cnameArray = array_flip(ThanhVien::$christianNames);
							$_cnameArray = ThanhVien::$christianNames;
							if(array_key_exists($_cname, $_cnameArray)) {
								$_cname = mb_strtoupper($_cname);
							} else {
								throw new InvalidArgumentException('Christian Name no found: ' . $_cname);
							};
						}
					}
					
					$_mname = $phpExcelObject->getActiveSheet()->getCell('D' . $row)->getValue();
					if( ! empty($_mname)) {
						$_mname = mb_strtoupper(trim($_mname));
					}
					
					$_fname = $phpExcelObject->getActiveSheet()->getCell('E' . $row)->getValue();
					if( ! empty($_fname)) {
						$_fname = mb_strtoupper(trim($_fname));
					}
					
					$_qname = $phpExcelObject->getActiveSheet()->getCell('F' . $row)->getValue();
					if( ! empty($_qname)) {
						$_qname = mb_strtoupper(trim($_qname));
					}
					
					
					$_idNumber = trim($phpExcelObject->getActiveSheet()->getCell('A' . $row)->getValue());
					$_phone    = (trim($phpExcelObject->getActiveSheet()->getCell('G' . $row)->getValue()));
					$_address  = (trim($phpExcelObject->getActiveSheet()->getCell('H' . $row)->getValue()));
					$_doi      = (trim($phpExcelObject->getActiveSheet()->getCell('I' . $row)->getValue()));
					$_chiDoan  = (trim($phpExcelObject->getActiveSheet()->getCell('J' . $row)->getValue()));


//					$_dobCell     = $phpExcelObject->getActiveSheet()->getCell('F' . $row);
//					$_dobString   = $_dobCell->getValue();

//					if(\PHPExcel_Shared_Date::isDateTime($_dobCell)) {
//						$_dob = new \DateTime('@' . \PHPExcel_Shared_Date::ExcelToPHP($_dobString));
//					} elseif( ! empty($_dobString)) {
//						$_dob = \DateTime::createFromFormat('d/m/Y', $_dobString);
//					}

//					$_gender = $phpExcelObject->getActiveSheet()->getCell('G' . $row)->getValue();
//					if(mb_strtoupper($_gender) === 'MALE') {
//						$_gender = 'Male';
//					}

//					if(mb_strtoupper($_gender) === 'FEMALE') {
//						$_gender = 'Female';
//					}
//					if( ! in_array($_gender, [ 'Male', 'Female' ])) {
//						$_gender = null;
//					}

//					$email = $phpExcelObject->getActiveSheet()->getCell('H' . $row)->getValue();
					if( ! empty($_idNumber)) {
						$thanhVien = $thanhVienRepo->findOneBy([ 'code' => $_idNumber ]);
					} else {
						$thanhVien = null;
					}
					
					if(empty($thanhVien)) {
						$thanhVien = new ThanhVien();
						$thanhVien->setFirstname($_fname);
						$thanhVien->setLastname($_lname);
						$thanhVien->setMiddlename($_mname);
						$thanhVien->setApproved(true);
						
						$thanhVien->setQuickName($_qname);
						$thanhVien->setChristianname($_cname);
						if(array_key_exists($_cname, ThanhVien::$christianNameSex)) {
							$thanhVien->setSex(ThanhVien::$christianNameSex[ $_cname ]);
						}
						$thanhVien->setName($_cname . ' ' . $_lname . ' ' . $_mname . ' ' . $_fname);
						$thanhVien->setThieuNhi(true);
						$thanhVien->setHuynhTruong(false);
						$thanhVien->setChiDoan($_chiDoan);
						$thanhVien->setPhanDoan(ThanhVien::$danhSachChiDoan[ intval($_chiDoan) ]);
						$thanhVien->setNamHoc(intval($namHoc));
						$thanhVien->setSoDienThoai($_phone);
						$thanhVien->setDiaChiThuongTru($_address);
					}
					$thanhVien->setEnabled(true);
					
					$chiDoanRepo = $this->getDoctrine()->getRepository(ChiDoan::class);
					$namHocRepo  = $this->getDoctrine()->getRepository(NamHoc::class);
					
					$namHocObj = $namHocRepo->find($namHoc);
					$chiDoan   = $chiDoanRepo->findOneBy([ 'namHoc' => $namHoc, 'name' => ($_chiDoan) ]);
					if(empty($chiDoan)) {
						$chiDoan = new ChiDoan();
						$chiDoan->setNamHoc($namHocObj);
						$chiDoan->setPhanDoan(ThanhVien::$danhSachChiDoan[ intval($_chiDoan) ]);
						$chiDoan->setName(($_chiDoan));
						$chiDoan->setNumber(intval($_chiDoan));
						$chiDoan->generateId();
						$manager->persist($chiDoan);
						$manager->flush($chiDoan);
					}
					
					if(empty($phanBo = $thanhVien->getPhanBoNamNay())) {
						$phanBo = new PhanBo();
						$phanBo->setPhanDoan(ThanhVien::$danhSachChiDoan[ intval($_chiDoan) ]);
						$phanBo->setChiDoan($chiDoan);
						$phanBo->setThanhVien($thanhVien);
						$phanBo->setHuynhTruong(false);
						$phanBo->setThieuNhi(true);
					}
					
					$doi = intval($_doi);
					
					$dngl = $chiDoan->getDoiNhomGiaoLy($doi);
					$dngl->getPhanBoHangNam()->add($phanBo);
					$phanBo->setDoiNhomGiaoLy($dngl);
					
					$manager = $this->get('doctrine.orm.default_entity_manager');
					$manager->persist($dngl);
					$manager->persist($phanBo);
					$manager->persist($chiDoan);
					$manager->persist($thanhVien);
					
					$successfulRow ++;
					$row ++;
				}
				try {
					$manager->flush();
					
					$allThanhVien = $thanhVienRepo->findAll();
					/** @var ThanhVien $thanhVien */
					foreach($allThanhVien as $thanhVien) {
						$thanhVien->setCode(mb_strtoupper(User::generate4DigitCode($thanhVien->getId())));
						$manager->persist($thanhVien);
					}
					
					$manager->flush();

//                    $employeeArray = $conn->fetchAll('SELECT * FROM mhs__employer__employee WHERE state LIKE \'' . BusinessEmployee::STATE_DRAFT . '\' AND id_employer = ' . $id);
//                    $resigneeCount = 0;
//                    if (count($employeeArray) > 0) {
//                        foreach ($employeeArray as $_employee) {
//                            $conn->update('mhs__employer__employee', array('enabled' => false, 'state' => BusinessEmployee::STATE_PUBLISHED), array('id' => $_employee['id']));
//                            $resigneeCount++;
//                        }
//                    }
					
					$this->addFlash('sonata_flash_success', sprintf("%s employee(s) has/have been imported.", $successfulRow));
					
				} catch(\Exception $exception) {
					$this->addFlash('sonata_flash_error', $exception->getMessage());
				}
				unlink($filePath);
			}
		}
		
		return new RedirectResponse($this->generateUrl('admin_app_binhle_thieunhi_phanbo_list', [
		
		]));
	}
	
	
	public function listAction() {
		/** @var ThanhVienAdmin $admin */
		$admin = $this->admin;
		
		if( ! empty($namHoc = $this->get('app.binhle_thieunhi_namhoc')->getNamHocHienTai())) {
			$admin->setNamHoc($namHoc->getId());
		}
		
		return parent::listAction();
	}
	
}