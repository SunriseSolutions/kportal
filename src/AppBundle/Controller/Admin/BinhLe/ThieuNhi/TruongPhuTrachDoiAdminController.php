<?php
namespace AppBundle\Controller\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BinhLe\ThieuNhi\ChiDoanAdmin;
use AppBundle\Admin\BinhLe\ThieuNhi\TruongPhuTrachDoiAdmin;
use AppBundle\Controller\Admin\BaseCRUDController;
use AppBundle\Entity\BinhLe\ThieuNhi\ChiDoan;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TruongPhuTrachDoiAdminController extends BaseCRUDController {

	
}