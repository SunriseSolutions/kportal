<?php

namespace AppBundle\Admin\BinhLe\ThieuNhi;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\BinhLe\ThieuNhi\DoiNhomGiaoLy;
use AppBundle\Entity\BinhLe\ThieuNhi\PhanBo;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use AppBundle\Entity\BinhLe\ThieuNhi\TruongPhuTrachDoi;
use Bean\Bundle\CoreBundle\Service\StringService;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Psr\Container\ContainerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Validator\Constraints\Valid;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

abstract class BinhLeThieuNhiAdmin extends BaseAdmin {
	/** @var ThanhVien $thanhVien */
	protected $thanhVien = null;
	
	public function toString($object) {
		if($object instanceof ThanhVien) {
			return $object->getName();
		}
		if($object instanceof PhanBo) {
			return $object->getThanhVien()->getName();
		}
		if($object instanceof DoiNhomGiaoLy) {
			$cacTruong = $object->getCacTruongPhuTrachDoi();
			$str       = 'Đội của ';
			/** @var TruongPhuTrachDoi $truong */
			foreach($cacTruong as $truong) {
				$tv  = $truong->getPhanBoHangNam()->getThanhVien();
				$str .= $tv->getTitle() . ' ' . $tv->getFirstname();
			}
			
			return $str;
		}
		
		return parent::toString($object);
	}
	
	protected function getUserThanhVien() {
		if(empty($this->thanhVien)) {
			$container       = $this->getConfigurationPool()->getContainer();
			$user            = $container->get('app.user')->getUser();
			$this->thanhVien = $user->getThanhVien();
		}
		
		return $this->thanhVien;
	}
	
	protected function getUserChiDoan() {
		
		return $this->getUserThanhVien()->getChiDoan();
		
	}
}