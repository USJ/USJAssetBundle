<?php 
namespace MDB\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Form\FormViewInterface,
	Symfony\Component\Form\FormInterface,
	Symfony\Component\OptionsResolver\OptionsResolverInterface,
	Symfony\Component\Form\FormView;


class StatusType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text');

		$builder->add('isDefault', 'checkbox', array(
			'label' => 'displayed as default',
			'required' => false
		));

		$builder->add('countedAsRunning', 'checkbox', array(
            'label'  => 'Is counted in running',
            'required'	   => false
		));

	}

	public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    		'data_class' => 'MDB\AssetBundle\Document\Status'
		));
    }

    public function getName()
    {
    	return 'status';
    }
}