<?php
namespace MDB\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormViewInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\FormView;

use Symfony\Component\Validator\Constraints\NotBlank;

class AssetPropertyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            // 'label_render' => false,
            'constraints' => new NotBlank()
        ));

        $builder->add('value', 'text', array(
            // 'label_render' => false,
            'constraints' => new NotBlank()
        ));
    }

    public function getName()
    {
        return 'mdb_asset_asset_property';
    }
}
