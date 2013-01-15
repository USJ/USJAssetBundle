<?php 
namespace MDB\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Form\FormViewInterface,
	Symfony\Component\Form\FormInterface,
	Symfony\Component\OptionsResolver\OptionsResolverInterface,
	Symfony\Component\Form\FormView;

class AssetPropertyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('property');
		$builder->add('value');
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    		'data_class' => 'MDB\AssetBundle\Document\AssetProperty'
    	));
    }

    public function getName()
    {
    	return 'asset_property';
    }
}