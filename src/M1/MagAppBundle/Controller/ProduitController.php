<?php

namespace M1\MagAppBundle\Controller;

use M1\MagAppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use M1\MagAppBundle\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;


class ProduitController extends Controller
{
    public function addAction(Request $request)
    {
    	$produit = new Produit();

        $form   = $this->get('form.factory')->create(ProduitType::class, $produit);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($produit);
             $em->flush();

             $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

             return $this->redirectToRoute('saved_categorie', array('id' => $produit->getId()));
    }

    return $this->render('M1MagAppBundle:Magasinier:Form_Ajout_Produit.html.twig', array(
      'form' => $form->createView(),
    ));

        //return $this->render('M1MagAppBundle:Default:index.html.twig');
    }
}
