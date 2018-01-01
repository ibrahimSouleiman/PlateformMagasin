<?php

namespace M1\MagAppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitSearchType extends AbstractType
{
 
 public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('nom', TextType::class)
            ->add('reference', TextType::class)->getForm();

      /*return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));*/
    }
    
    public function getName()
	{
    return 'produit_MagAppbundle_recherche';
	}
}