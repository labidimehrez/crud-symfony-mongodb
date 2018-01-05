<?php

/**
 * @author Mehrez Labidi
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class productType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, array('required' => true,
                    'attr' => array(
                        'placeholder' => '',
                        'class' => 'form-control',
                    //                        ,'style' => 'width:10%;'
                    ),
                ))
                ->add('price', TextType::class, array('required' => true,
                    'attr' => array(
                        'placeholder' => '',
                        'class' => 'form-control',
                    //                        ,'style' => 'width:10%;'
                    ),
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\Product',
        ));
    }

    public function getBlockPrefix() {
        return 'product';
    }

}
