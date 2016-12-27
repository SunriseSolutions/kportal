<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\ClassificationBundle\Admin;

use Sonata\ClassificationBundle\Admin\TagAdmin as BaseTagAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TagAdmin extends BaseTagAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')            
        ;
		$hide_context = $this->getPersistentParameter('hide_context');
		$context = $this->getPersistentParameter('context');

		if(empty($hide_context) || empty($context)){
			$formMapper->add('context');
		}
		
        if ($this->hasSubject() && $this->getSubject()->getId()) {
            $formMapper->add('slug');
        }

        $formMapper->add('enabled', null, array('required' => false));
    }
}
