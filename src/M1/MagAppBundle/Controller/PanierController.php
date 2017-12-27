<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
use M1\MagAppBundle\Entity\Adresses;
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/
use M1\MagAppBundle\Form\PaniersType;
/********************************/

use M1\MagAppBundle\Repository\PaniersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class PanierController extends Controller
{

    public function enregistreadresseAction($refadresse)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryPanier= $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');
        $repositoryAdresse= $this->getDoctrine()->getRepository('M1MagAppBundle:Adresses');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $adresse = $em->getRepository(Adresses::class)->findOneById($refadresse);
        $panier=  $em->getRepository(Paniers::class)->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));

          $panier->setAdresse($adresse);
          $em->persist($panier);
          $em->flush();


        return $this->redirectToRoute('m1_mag_app_validerpanierpage');
    }


    public function valideAction(Request $request)
    {
        $repositoryCommande= $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
        $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $panier= $repositoryPanier->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));
        $commandes = $repositoryCommande->findByPanier($panier);

        if ($request->isMethod('POST') ) {
            $em = $this->getDoctrine()->getManager();

            $panier->setEtat("valider");
            $em->flush();

            return $this->redirectToRoute('m1_mag_app_homepage');

        }

        return $this->render("M1MagAppBundle:Produit:valide_panier.html.twig", array('commandes'=> $commandes,'Adresse' => $panier->getAdresse(),'user'=>$user->getId()));

    }
/*****************************************************************************************/
 public function listPanierAction(Request $request)
    {
           $Panier = new Paniers();

		   $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');
		   $paniers = $repository->findPanierValider();

		//$produit = $em->getRepository(Produit::class)->find($id);
      /*     $form = $this->createFormBuilder($Panier)
                ->setMethod('POST')
                ->add('save', SubmitType::class)
                ->getForm();
       // $form  = $this->get('form.factory')->create(PaniersType::class, $Panier);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($paniers);
             $em->flush();


             return $this->redirectToRoute('saved_categorie', array('id' => $paniers->getId()));
            }*/
   
   return $this->render("M1MagAppBundle:Magasinier:List_Panier.html.twig",['paniers'=> $paniers]);
  // return $this->render("M1MagAppBundle:Magasinier:List_Stock.html.twig", ['produits'=> $produits]);
    }


    public function validerPanierAction($id)
    {
    	 //$Panier = new Paniers();
     
         $em = $this->getDoctrine()->getManager();
		 $panier = $em->getRepository(Paniers::class)->find($id);

		 // verifier le stock

		$panier->setEtat("traité");

		 $em->persist($panier);
         $em->flush();

  		return $this->redirectToRoute('list_panier');
    }

    public function detailsPanierAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		$panier = $em->getRepository(Paniers::class)->find($id);

		return $this->render("M1MagAppBundle:Magasinier:Cmd_Panier.html.twig",['panier'=> $panier]);

    }

}