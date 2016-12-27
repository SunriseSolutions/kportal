<?php
namespace Application\Sonata\ClassificationBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\ClassificationBundle\Admin\CategoryAdmin as BaseCategoryAdmin;
use Sonata\ClassificationBundle\Model\ContextManagerInterface;
use Symfony\Component\Validator\Constraints\Valid;

class CategoryAdmin extends BaseCategoryAdmin
{
    protected $formOptions = array();

    function __construct($code, $class, $baseControllerName, ContextManagerInterface $contextManager)
    {
        parent::__construct($code, $class, $baseControllerName, $contextManager);
        $this->formOptions = array('constraints' => new Valid());

    }

    public function getPersistentParameters()
    {
        $parameters = parent::getPersistentParameters();
        foreach ($this->getExtensions() as $extension) {
            $params = $extension->getPersistentParameters($this);
            if (!is_array($params)) {
                throw new \RuntimeException(sprintf('The %s::getPersistentParameters must return an array', get_class($extension)));
            }

            $parameters = array_merge($parameters, $params);
        }
//        $params['my_love_I_have_st_to_tell_you'] = 'I-love-you';
        return $parameters;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->formOptions = array('constraints' => new Valid());

        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
//            ->add('locale','hidden',array('empty_data'=>$this->getRequest()->get('tl','en')))
            ->add('description', 'textarea', array(
                'required' => false,
            ));

        if ($this->hasSubject()) {
            if ($this->getSubject()->getParent() !== null || $this->getSubject()->getId() === null) { // root category cannot have a parent
                $formMapper
                    ->add('parent', 'sonata_category_selector', array(
//                      'category' => $this->getSubject() ?: null,
                        'model_manager' => $this->getModelManager(),
                        'class' => $this->getClass(),
                        'required' => true,
//                      'context' => $this->getSubject()->getContext(),
                    ));
            }
        }

        $position = $this->hasSubject() && !is_null($this->getSubject()->getPosition()) ? $this->getSubject()->getPosition() : 0;

        $formMapper
            ->end()
            ->with('Options', array('class' => 'col-md-6'))
            ->add('enabled', null, array(
                'required' => false,
            ))
            ->add('position', 'integer', array(
                'required' => false,
                'data' => $position,
            ))
            ->end();

        if (interface_exists('Sonata\MediaBundle\Model\MediaInterface')) {
            $formMapper
                ->with('General')
                ->add('media', 'sonata_type_model_list',
                    array(
                        'required' => false,
                    ),
                    array(
                        'link_parameters' => array(
                            'provider' => 'sonata.media.provider.image',
                            'context' => 'sonata_category',
                        ),
                    )
                )
                ->end();
        }
    }

}