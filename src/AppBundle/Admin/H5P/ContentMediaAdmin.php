<?php

namespace AppBundle\Admin\H5P;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\H5P\ContentMedia;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContentMediaAdmin extends BaseAdmin {
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('title', 'text', [ 'editable' => true ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper
//			->add('content')
//			->add('media', MediaType::class, [
//				'label' => 'form.label_media',
//				'required' => false,
//				'provider' => 'sonata.media.provider.image',
//				'context' => 'default'
//			])
			->add('media', 'sonata_type_model_autocomplete', array(
				'property' => 'name',
				'callback' => function($admin, $property, $value) {
					$datagrid = $admin->getDatagrid();
					/** @var QueryBuilder $queryBuilder */
					$queryBuilder = $datagrid->getQuery();
					$expr         = $queryBuilder->expr();
					$queryBuilder
						->andWhere(
							$expr->orX(
								$expr->eq($queryBuilder->getRootAliases()[0] . '.providerName', ':imageProviderName')
								,
								$expr->eq($queryBuilder->getRootAliases()[0] . '.providerName', ':youtubeProviderName')
							)
						)
						->setParameter('imageProviderName', 'sonata.media.provider.image')
						->setParameter('youtubeProviderName', 'sonata.media.provider.youtube');
					$datagrid->setValue($property, null, $value);
				},
			));
		
		$formMapper
			->end()
			->end();
		
	}
	
}