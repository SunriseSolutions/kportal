<?php

namespace AppBundle\Admin;

use AppBundle\Entity\ChannelPartner\ChannelPartner;
use AppBundle\Entity\ChannelPartner\ChannelPartnerProduct;
use AppBundle\Entity\Principal\Clinic;
use AppBundle\Entity\SalesPartner\SalesAccount;
use Application\Bean\OrganisationBundle\Entity\Position;
use Bean\Bundle\CoreBundle\Service\StringService;

use Application\Bean\OrganisationBundle\Entity\Organisation;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

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

abstract class BaseAdmin extends AbstractAdmin
{
	protected $ivoryCkeditor = array();
	
    protected $translationDomain = 'AppAdmin'; // default is 'messages'

    protected $listModes = array(
        'list' => array(
            'class' => 'fa fa-list fa-fw',
        ),
//        'mosaic' => array(
//            'class' => self::MOSAIC_ICON_CLASS,
//        ),
    );

    public function getRequest()
    {
        if (!$this->request) {
//            throw new \RuntimeException('The Request object has not been set');
            $this->request = $this->getConfigurationPool()->getContainer()->get('request_stack')->getCurrentRequest();
        }
        return $this->request;
    }


    public function getListModes()
    {
        return array(
            'list' => array(
                'class' => 'fa fa-list fa-fw',
            ),
//        'mosaic' => array(
//            'class' => self::MOSAIC_ICON_CLASS,
//        ),
        );
    }

    private $isAdmin;

    protected function isAdmin()
    {
        if ($this->isAdmin === null) {
            $this->isAdmin = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        }
        return $this->isAdmin;
    }

    /**
     * @param ProxyQuery $query
     * @return ProxyQuery
     */
    protected function clearResults(ProxyQuery $query)
    {
        /** @var Expr $expr */
        $expr = $query->getQueryBuilder()->expr();
        $query->andWhere($expr->eq($expr->literal(true), $expr->literal(false)));
        return $query;
    }

    protected function verifyDirectParent($parent)
    {
    }

    protected function isDirectParentAccess($parentClass, $subjectAdminCodes = array())
    {
        $parentAdmin = $this->getParent();
        $isDirectParentAccess = false;
        if (!empty($parentAdmin)) {
            $_parentClass = $parentAdmin->getClass();
            $isDirectParentAccess = $parentClass === $_parentClass;
            if (!empty($subjectAdminCodes)) {
                $isDirectParentAccess = $isDirectParentAccess && (in_array($this->getCode(), $subjectAdminCodes));
            }
        }
        return $isDirectParentAccess;
    }

    protected function isAppendFormElement()
    {
        $request = $this->getRequest();
        return $request->attributes->get('_route') === 'sonata_admin_append_form_element';
    }

    protected function filterByParentClass(ProxyQuery $query, $parentClass, $subjectAdminCodes = array())
    {
        $pool = $this->getConfigurationPool();
        $request = $this->getRequest();
        $container = $pool->getContainer();
        /** @var Expr $expr */
        $expr = $query->getQueryBuilder()->expr();

        $isDirectParentAccess = $this->isDirectParentAccess($parentClass, $subjectAdminCodes);
        $parentAdmin = $this->getParent();

        if ($isDirectParentAccess) {
            if ($this->verifyDirectParent($parentAdmin->getSubject())) {
                $query->andWhere($expr->eq('o.' . $this->getParentAssociationMapping(), $parentAdmin->getSubject()->getId()));
                return $query;
            };
        } else {
            if ($this->isAppendFormElement()) {
                // Indirect Parent
                $code = $request->query->get('code');
                $objectId = $request->query->get('objectId');

                if (in_array($code, $subjectAdminCodes)) {
                    /** @var AdminInterface $childAdmin */
                    $childAdmin = $pool->getAdminByAdminCode($code);
                    $child = $this->getModelManager()->find($childAdmin->getClass(), $objectId);
                    $indirectParentAssociationMapping = $childAdmin->getParentAssociationMapping();
                    $parentGetter = 'get' . ucfirst($indirectParentAssociationMapping);
                    $indirectParent = $child->{$parentGetter}();
//                    definitely null =>
//                    $indirectParentAdmin = $childAdmin->getParent();
                    if (get_class($indirectParent) === $parentClass) {
                        $query->andWhere($expr->eq('o.' . $childAdmin->getParentAssociationMapping(), $indirectParent->getId()));
                        return $query;
                    }
                }

            } else {
                // Indirect Parent but with direct access NOT Ajax call
                $childAdmin = $pool->getAdminByAdminCode($request->attributes->get('_sonata_admin'));
                $query->andWhere($expr->eq('o.' . $childAdmin->getParentAssociationMapping(), $request->attributes->get('id')));
                return $query;
            }
        }
        return $this->clearResults($query);
    }

    protected function getPositionOrganisation()
    {
        $pos = $this->getConfigurationPool()->getContainer()->get('app.user')->getPosition();
        if (empty($pos)) {
            return null;
        }
        return $pos->getEmployer();
    }
	
	/**
	 * @return array
	 */
	public function getIvoryCkeditor() {
		return $this->ivoryCkeditor;
	}
	
	/**
	 * @param array $ivoryCkeditor
	 */
	public function setIvoryCkeditor( $ivoryCkeditor ) {
		$this->ivoryCkeditor = $ivoryCkeditor;
	}
}