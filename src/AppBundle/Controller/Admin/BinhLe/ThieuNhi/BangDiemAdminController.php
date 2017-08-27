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
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
	
	public function nhapDiemThieuNhiAction(PhanBo $phanBo, Request $request) {
		/** @var BangDiemAdmin $admin */
		$admin   = $this->admin;
		$manager = $this->get('doctrine.orm.default_entity_manager');
		/** @var User $user */
		$user      = $this->getUser();
		$thanhVien = $user->getThanhVien();;
		if(empty($_phanBo = $thanhVien->getPhanBoNamNay())) {
			throw new NotFoundHttpException('No Group Assignment found');
		}
		
		if($_phanBo->getId() !== $phanBo->getId()) {
			if( ! $_phanBo->quanLy($phanBo)) {
				throw new UnauthorizedHttpException('not authorised');
			}
		}
		
		$chiDoan = $phanBo->getChiDoan();
		$hocKy   = 1;
		if($chiDoan->isDuocDuyetBangDiemHK1()) {
			$hocKy = 2;
		}
		
		$cotDiemHeaders     = [];
		$cotDiemAttrs       = [];
		$cotDiemLabels      = [];
		$cotDiemCellFormats = [];
		if($hocKy === 1) {
			$cotDiemHeaders['cc9']               = 'CC-9';
			$cotDiemHeaders['cc10']              = 'CC-10';
			$cotDiemHeaders['cc11']              = 'CC-11';
			$cotDiemHeaders['cc12']              = 'CC-12';
			$cotDiemHeaders['tbCCTerm1']         = 'TB. CC';
			$cotDiemHeaders['quizTerm1']         = 'TB. Miệng';
			$cotDiemHeaders['midTerm1']          = 'Điểm 1 Tiết';
			$cotDiemHeaders['finalTerm1']        = 'Thi HK1';
			$cotDiemHeaders['tbTerm1']           = 'TB. HK1';
			$cotDiemHeaders['sundayTicketTerm1'] = 'Phiếu lễ CN';
			
			$cotDiemAttrs['cc9']               = 'cc9';
			$cotDiemAttrs['cc10']              = 'cc10';
			$cotDiemAttrs['cc11']              = 'cc11';
			$cotDiemAttrs['cc12']              = 'cc12';
			$cotDiemAttrs['tbCCTerm1']         = 'tbCCTerm1';
			$cotDiemAttrs['quizTerm1']         = 'quizTerm1';
			$cotDiemAttrs['midTerm1']          = 'midTerm1';
			$cotDiemAttrs['finalTerm1']        = 'finalTerm1';
			$cotDiemAttrs['tbTerm1']           = 'tbTerm1';
			$cotDiemAttrs['sundayTicketTerm1'] = 'sundayTicketTerm1';
			
			$cotDiemLabels['cc9']               = 'điểm Chuyên-cần tháng 9';
			$cotDiemLabels['cc10']              = 'điểm Chuyên-cần tháng 10';
			$cotDiemLabels['cc11']              = 'điểm Chuyên-cần tháng 11';
			$cotDiemLabels['cc12']              = 'điểm Chuyên-cần tháng 12';
			$cotDiemLabels['tbCCTerm1']         = 'điểm Trung-bình Chuyên-cần';
			$cotDiemLabels['quizTerm1']         = 'điểm Trung-bình Miệng';
			$cotDiemLabels['midTerm1']          = 'điểm 1 Tiết/Giữa-kỳ';
			$cotDiemLabels['finalTerm1']        = 'điểm Thi Cuối-kỳ';
			$cotDiemLabels['tbTerm1']           = 'điểm Trung-bình Học-kỳ 1';
			$cotDiemLabels['sundayTicketTerm1'] = 'phiếu lễ Chúa-nhật';
			
			$cotDiemCellFormats ['cc9']               = "type:'numeric', format: '0,0.0'";
			$cotDiemCellFormats ['cc10']              = "type:'numeric', format: '0,0.0'";
			$cotDiemCellFormats ['cc11']              = "type:'numeric', format: '0,0.0'";
			$cotDiemCellFormats ['cc12']              = "type:'numeric', format: '0,0.0'";
			$cotDiemCellFormats ['tbCCTerm1']         = "type:'numeric',readOnly:true, format: '0,0.00'";
			$cotDiemCellFormats ['quizTerm1']         = "type:'numeric', format: '0,0.0'";
			$cotDiemCellFormats ['midTerm1']          = "type:'numeric', format: '0,0.0'";
			$cotDiemCellFormats ['finalTerm1']        = "type:'numeric', format: '0,0.00'";
			$cotDiemCellFormats ['tbTerm1']           = "type:'numeric',readOnly:true, format: '0,0.00'";
			$cotDiemCellFormats ['sundayTicketTerm1'] = "type:'numeric'";
		} elseif($hocKy === 2) {
		
		}
		
		$cacCotDiemBiLoaiBo = $chiDoan->getCotDiemBiLoaiBo();
		foreach($cacCotDiemBiLoaiBo as $cotDiemBiLoaiBo) {
			unset($cotDiemHeaders[ $cotDiemBiLoaiBo ], $cotDiemAttrs[ $cotDiemBiLoaiBo ], $cotDiemCellFormats[ $cotDiemBiLoaiBo ], $cotDiemLabels[ $cotDiemBiLoaiBo ]);
		}
		
		if($request->isMethod('post')) {
			$diem    = floatval($request->request->get('diem', 0));
			$cotDiem = $request->request->getAlnum('cotDiem');
			if( ! in_array($cotDiem, array_values($cotDiemAttrs))) {
				return new JsonResponse([ 415, 'Không hỗ trợ Cột-điểm này' ], 415);
			}
			
			$phanBoId      = $request->request->get('phanBoId');
			$phanBo        = $this->getDoctrine()->getRepository(PhanBo::class)->find($phanBoId);
			
			if( ! ($diem === null || empty($phanBo))) {
				$bangDiem = $phanBo->getBangDiem();
				$setter   = 'set' . ucfirst($cotDiem);
				$bangDiem->$setter($diem);
				$manager = $this->get('doctrine.orm.default_entity_manager');
				
				if(substr($cotDiem, 0, 2) === 'cc') {
					$bangDiem->tinhDiemChuyenCan($hocKy);
					$bangDiem->tinhDiemHocKy($hocKy);
				} elseif(substr($cotDiem, 0, 6) !== 'sunday') {
					$bangDiem->tinhDiemHocKy($hocKy);
				}
				
				$tbCC = 0;
				if($hocKy === 1) {
					$tbCC      = $bangDiem->getTbCCTerm1();
					$tbTerm    = $bangDiem->getTbTerm1();
					$tbYear    = 0;
					$category  = '';
					$retention = '';
					$awarded   = '';
				} elseif($hocKy === 2) {
					$tbCC      = $bangDiem->getTbCCTerm2();
					$tbTerm    = $bangDiem->getTbTerm2();
					$tbYear    = $bangDiem->getTbYear();
					$category  = $bangDiem->getCategory();
					$retention = $bangDiem->isGradeRetention();
					$awarded   = $bangDiem->isAwarded();
				}
				
				$manager->persist($bangDiem);
//				$manager->persist($phanBo);
//				$manager->persist($chiDoan);
				$manager->flush();

//
				return new JsonResponse([ 'tbCC' => $tbCC, 'tbTerm' => $tbTerm, 'tbYear' => $tbYear ], 200);
			} else {
				return new JsonResponse([ 404, 'Không thể tìm thấy Thiếu-nhi này' ], 404);
			}
		}
		
		$cacTruongPT   = $phanBo->getCacTruongPhuTrachDoi();
		$phanBoHangNam = new ArrayCollection();
		/** @var TruongPhuTrachDoi $truongPT */
		foreach($cacTruongPT as $truongPT) {
			$phanBoHangNam = new ArrayCollection(array_merge($phanBoHangNam->toArray(), $truongPT->getDoiNhomGiaoLy()->getPhanBoHangNam()->toArray()));
		}
		
		if($phanBoHangNam->count() > 0) {
			$array       = $phanBoHangNam->toArray();
			$phanBoArray = [];
			$sortedArray = [];
			$returnArray = [];
			/** @var PhanBo $phanBoItem */
			foreach($array as $phanBoItem) {
				$firstName                           = $phanBoItem->getThanhVien()->getFirstname();
				$sortedArray[ $phanBoItem->getId() ] = $firstName;
				$phanBoArray[ $phanBoItem->getId() ] = $phanBoItem;
				$manager->persist($phanBoItem->createBangDiem());
			}
			$manager->flush();
			$phanBoHangNamSorted = true;
			$collator            = new \Collator('vi_VN');
			$collator->asort($sortedArray);
			foreach($sortedArray as $id => $name) {
				$returnArray[] = $phanBoArray[ $id ];
			}
			$phanBoHangNam = new ArrayCollection(($returnArray));
		}
		
		$admin->setAction('nhap-diem-thieu-nhi');
		$admin->setActionParams([
			'chiDoan'        => $phanBo->getChiDoan(),
			'phanBo'         => $phanBo,
			'phanBoHangNam'  => $phanBoHangNam,
			'hocKy'          => $hocKy,
			'cotDiemHeaders' => $cotDiemHeaders,
			'cotDiemAttrs'   => $cotDiemAttrs,
			'cotDiemLabels'  => $cotDiemLabels,
			
			'cotDiemCellFormats' => $cotDiemCellFormats,
			'christianNames'     => ThanhVien::$christianNames
		]);
		
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
				$thanhVienRepo  = $this->getDoctrine()->getRepository(ThanhVien::class);
				$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($filePath);
				$row            = 5;
				$successfulRow  = 0;
				
				while(true) {
					$_lname = $phpExcelObject->getActiveSheet()->getCell('C' . $row)->getValue();
					if(empty($_lname)) {
						break;
					}
					$_cname = $phpExcelObject->getActiveSheet()->getCell('B' . $row)->getValue();
					if( ! empty($_cname)) {
						$_cname = trim($_cname);
						if( ! empty($_cname)) {
							$_cnameArray = array_flip(ThanhVien::$christianNames);
							$_cname      = $_cnameArray[ $_cname ];
						}
					}
					
					$_mname = $phpExcelObject->getActiveSheet()->getCell('D' . $row)->getValue();
					if( ! empty($_mname)) {
						$_mname = trim($_mname);
					}
					
					$_qname = $phpExcelObject->getActiveSheet()->getCell('E' . $row)->getValue();
					if( ! empty($_qname)) {
						$_qname = trim($_qname);
					}
					
					$_fname = $phpExcelObject->getActiveSheet()->getCell('F' . $row)->getValue();
					if( ! empty($_fname)) {
						$_fname = trim($_fname);
					}
					
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
					$bangDiem->setSubmitted(true);
					$bangDiem->setSundayTickets(intval($_phieuLe));
					$bangDiem->setAwarded(($_awarded === 'X'));
					
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
					
					if($_retention === 'Ở LẠI') {
						$bangDiem->setGradeRetention(true);
					} elseif(($_retention = trim($phpExcelObject->getActiveSheet()->getCell('V' . $row)->getValue())) === 'Ở LẠI') {
						$bangDiem->setGradeRetention(true);
					} elseif($_retention === 'NGHỈ LUÔN') {
						$bangDiem->setGradeRetention(true);
						$thanhVien->setEnabled(true);
					} else {
						$bangDiem->setGradeRetention(false);
					}
					
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
						$chiDoan->setNumber(intval($_chiDoan));
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
					
					$allThanhVien = $thanhVienRepo->findAll();
					/** @var ThanhVien $thanhVien */
					foreach($allThanhVien as $thanhVien) {
						$thanhVien->setCode(strtoupper(User::generate4DigitCode($thanhVien->getId())));
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
		
		return new RedirectResponse($this->generateUrl('admin_app_binhle_thieunhi_bangdiem_list', [
		
		]));
	}
	
	
}