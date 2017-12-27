<?php

namespace M1\MagAppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdressesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('adresse',TextType::class)
            ->add('ville',TextType::class)
            ->add('codepostal',IntegerType::class)
            ->add('region',TextType::class)
            ->add('pays',TextType::class)
            ->add('telephone',TextType::class)
            ->add('save',SubmitType::class,array('label'=> 'Ajouter '));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'M1\MagAppBundle\Entity\Adresses'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'm1_magappbundle_adresses';
    }


}
