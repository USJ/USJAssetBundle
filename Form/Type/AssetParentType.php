<?php 
namespace MDB\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilderInterface,
	MDB\AssetBundle\Form\DataTransformer\NameToAssetTransformer,
	Symfony\Component\OptionsResolver\OptionsResolverInterface,
	Doctrine\Common\Persistence\ObjectManager;


class AssetParentType extends AbstractType
{
	private $om;
	public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new NameToAssetTransformer($this->om);
		$builder->addModelTransformer($transformer);
	}

	// public function setDefaultOptions(OptionsResolverInterface $resolver)
 //    {
 //        $resolver->setDefaults(array(
 //            'data_class' => 'MDB\LocatorBundle\Document\Place',
 //        ));
 //    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
    	return 'mdb_asset_asset_parent';
    }
}