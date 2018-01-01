<?php

namespace M1\MagAppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use M1\MagAppBundle\Form\ImagesType;
use M1\MagAppBundle\Repository\CategoriesRepository;
use M1\MagAppBundle\Form\CategoriesType;


class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('reference', TextType::class)
            ->add('prix', TextType::class)
            ->add('quantite', TextType::class)
            ->add('details', TextareaType::class)
            ->add('categorie', EntityType::class, array(
                  'class' => 'M1MagAppBundle:Categories',
                  'choice_label'  => 'libelleCategorie',
                  'multiple'      => false,
                  'query_builder' => function(CategoriesRepository $rep){
                    return $rep->getAllCategories();
                  }
             ))
           ->add('image',     ImagesType::class) // Ajoutez cette ligne
            ->add('save', SubmitType::class);
           // ->add('categorie');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'M1\MagAppBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'm1_magappbundle_produit';
    }


}
