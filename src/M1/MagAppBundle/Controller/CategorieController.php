<?php

namespace M1\MagAppBundle\Controller;

use M1\MagAppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use M1\MagAppBundle\Form\CategoriesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class CategorieController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {
    	$categorie = new Categories();
    	
        $form = $this->get('form.factory')->create(CategoriesType::class, $categorie)
        ->add('save', SubmitType::class, array('label' => 'Enregistrer'));



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($categorie);
             $em->flush();

             $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

             return $this->redirectToRoute('add_prod', array('id' => $categorie->getId()));
    }

    return $this->render('M1MagAppBundle:Magasinier:Form_Ajout_Categorie.html.twig', array(
      'form' => $form->createView(),
    ));
    }

}
