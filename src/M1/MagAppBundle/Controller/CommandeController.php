<?php

namespace M1\MagAppBundle\Controller;

use M1\MagAppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use M1\MagAppBundle\Form\CategoriesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeController extends Controller
{


    public function listeAction(Request $request)
    {
        $categorie = new Categories();

        $form = $this->createFormBuilder()
            ->setMethod('POST')
//                ->setAction($this->generateUrl('setStock/'.$id))
            ->add('choix',ChoiceType::class, array(
                'choices' => array(array_combine(range(1,5),range(1,5)))))
            ->add('save', SubmitType::class,array('label'=> 'Recherche'))
            ->getForm();
        $form->handleRequest($request);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('saved_categorie', array('id' => $categorie->getId()));
        }

        return $this->render('M1MagAppBundle:Produit:Liste_Commande.html.twig', array(
            'form' => $form->createView(),
        ));
    }



}