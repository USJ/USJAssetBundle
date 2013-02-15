<?php 
namespace MDB\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormViewInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\FormView;

class AssetType extends AbstractType
{
    protected $assetClass;
    
    public function __construct($assetClass)
    {
        $this->assetClass = $assetClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name','text', array(
            'label' => '',
            'attr' => array('placeholder' => 'Title')
        ));

        $builder->add('description','textarea', array(
            'required' => false,
            'attr' => array('placeholder' => 'Detail description...')
        ));
        
        $builder->add('referenceId', 'text',  array(
            'label' => 'Reference ID'
        ));

        $builder->add('category', 'choice', array(
            'choices' => array('EQUIPMENT'=>'Equipment','FACILITY' => 'Facility'),
            'empty_value' => 'Choose category'
        ));

        $builder->add('status', 'choice', array(
                'choices' => array()
            )
        );

        $builder->add('parent', 'document', array(
            'class' => $this->assetClass,
            'property' => 'referenceId',
            'required' => false,
            'empty_value' => 'Empty for root asset'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // $resolver->addAllowedTypes(array('prefered_status'));
        $resolver->setDefaults(array(
            'data_class' => $this->assetClass,
        ));
    }

    public function getName()
    {
        return 'mdb_asset_asset';
    }
}