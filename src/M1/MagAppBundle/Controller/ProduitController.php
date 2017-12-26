<?php

namespace M1\MagAppBundle\Controller;

use M1\MagAppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use M1\MagAppBundle\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProduitController extends Controller
{
    public function addAction(Request $request)
    {
    	$produit = new Produit();

        $form  = $this->get('form.factory')->create(ProduitType::class, $produit);

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
    }

     public function listStockAction()
    {
           $em = $this->getDoctrine()->getManager();
		   $produits = $em->getRepository(Produit::class)->findAll();

		return $this->render("M1MagAppBundle:Magasinier:List_Stock.html.twig", ['produits'=> $produits]);
   
    }


       public function updateStockAction($id, Request $request)
    {
    	   $Prod = new Produit();
     
           $em = $this->getDoctrine()->getManager();
		   $produit = $em->getRepository(Produit::class)->find($id);
		   $AncienneQuantite = $produit->getQuantite();

            //$form = $this->createForm(ProduitType::class, $Prod);
  
            //$form = $this->get('form.factory')->createNamedBuilder('form', 'form')
		    $form = $this->createFormBuilder($Prod)
                ->setMethod('POST')
//                ->setAction($this->generateUrl('setStock/'.$id))
                ->add('quantite', TextType::class,  ['label' => 'Quantité à ajouter '])
                //->add('save', 'submit', ['label' => 'Quantité à ajouter'])
                ->add('save', SubmitType::class)
                ->getForm();

            $form->handleRequest($request);    

            if ($request->isMethod('POST') && $form->isValid()) {
            //$em->persist($produit);
              $quantite = $form->get('quantite')->getData();
              $somme = $AncienneQuantite + $quantite;
              $produit->setQuantite($somme);
              $em->flush();
              return $this->redirectToRoute('list_stock');
        }

		return $this->render("M1MagAppBundle:Magasinier:Update_Stock.html.twig", array('form' => $form->createView(),'produit'=> $produit));
   
    }
}
