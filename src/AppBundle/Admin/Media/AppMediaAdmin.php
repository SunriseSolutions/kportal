<?php

namespace AppBundle\Admin\Media;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Model\Metadata;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Sonata\MediaBundle\Provider\Pool;

class AppMediaAdmin extends MediaAdmin {
	public function configureListFields(ListMapper $listMapper) {
		parent::configureListFields($listMapper);
		$listMapper->add('contentType');
	}
}