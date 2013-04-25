<?php
namespace MDB\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormViewInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\FormView;

class TypeaheadAjaxType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'url' => $options['url']
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // $resolver->addAllowedTypes(array('prefered_status'));
        $resolver->setDefaults(array(
            'url' => null
        ));
    }

    public function getName()
    {
        return 'typeahead_ajax';
    }
}
