<?php

namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\BangDiemAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\ThanhVienAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\NamHoc;
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
					$_mname       = $phpExcelObject->getActiveSheet()->getCell('D' . $row)->getValue();
					$_qname       = $phpExcelObject->getActiveSheet()->getCell('E' . $row)->getValue();
					$_fname       = $phpExcelObject->getActiveSheet()->getCell('F' . $row)->getValue();
					
					$_cc1       = $phpExcelObject->getActiveSheet()->getCell('G' . $row)->getValue();
					
					$_idNumber    = trim($phpExcelObject->getActiveSheet()->getCell('A' . $row)->getValue());
					
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
					
					
					$employee = new BusinessEmployee();
					$employee->setFirstname($_fname);
					$employee->setLastname($_lname);
					$employee->setIdNumber($_idNumber);
					$employee->setEntitlement($_entitlement);
					$employee->setEmailAddress($email);
					
					if( ! empty($_dob)) {
						$employee->setDob($_dob);
					}
					if( ! empty($_gender)) {
						$employee->setGender($_gender);
					}
					
					if(empty($employeeFound = $object->isEmployeeExistent($employee))) {
						if($type === 'leaver') {
							$employee->setEnabled(false);
							$row ++;
							continue;
						} else {
							$object->addEmployee($employee);
							$employee->setState(BusinessEmployee::STATE_PUBLISHED);
							$employee->setEnabled(true);
							$successfulRow ++;
							$manager->persist($employee);
						}
					} else {
						if($type === 'leaver') {
							$row ++;
							if($employeeFound->isEnabled()) {
								if($employeeFound->getEmailAddress() !== $employee->getEmailAddress()) {
									$employeeFound->setEnabled(false);
									$this->addFlash('sonata_flash_error', 'The email address ' . $employee->getEmailAddress() . ' entered into the resignee list for Employee ID ' . $employee->getIdNumber() . ' is different from the one on our record which is ' . $employeeFound->getEmailAddress());
								} else {
									$successfulRow ++;
									$manager->persist($employeeFound);
								}
							}
							continue;
						} else {
							$employeeFound->setEnabled(true);
						}
						if($employeeFound->getName() !== $employee->getName() || $employeeFound->getDob() !== $employee->getDob() || $employeeFound->getEntitlement() !== $employee->getEntitlement() || $employeeFound->getGender() !== $employee->getGender() || ! $employeeFound->isEnabled() || $employeeFound->getEmailAddress() !== $employee->getEmailAddress() || $employeeFound->getState() === BusinessEmployee::STATE_DRAFT) {
							if( ! empty($_dob)) {
								$employeeFound->setDob($_dob);
							}
							if( ! empty($_gender)) {
								$employeeFound->setGender($_gender);
							}
							
							$employeeFound->setFirstname($_fname);
							$employeeFound->setLastname($_lname);
							$employeeFound->setEntitlement($_entitlement);
//                            $employeeFound->setEnabled(true);
							$employeeFound->setState(BusinessEmployee::STATE_PUBLISHED);

//                            $manager->persist($employeeFound);
						}
						
						$successfulRow ++;
						$manager->persist($employeeFound);
					}
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
		
		return new RedirectResponse($this->generateUrl('admin_app_binhle_thieunhi_thanhvien_thieuNhi', [
		
		]));
	}
	
	
}