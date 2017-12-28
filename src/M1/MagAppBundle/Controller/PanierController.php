<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
use M1\MagAppBundle\Entity\Adresses;
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;
use M1\MagAppBundle\Entity\Ventes;

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
            $today = date("Y-m-d H:i:s");

            $panier->setEtat("valider");

            $commandes->setDateHoraireValide($today);

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
       /*   $form = $this->createFormBuilder($Panier)
                ->setMethod('POST')
                ->add('save', SubmitType::class)
                ->getForm();  */
       // $form  = $this->get('form.factory')->create(PaniersType::class, $Panier);

       /* if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($paniers);
             $em->flush();


             return $this->redirectToRoute('saved_categorie', array('id' => $paniers->getId()));
            }*/
   
  // return $this->render("M1MagAppBundle:Magasinier:List_Panier.html.twig",array('form' => $form->createView(),'paniers'=> $paniers));
   return $this->render("M1MagAppBundle:Magasinier:List_Panier.html.twig", ['paniers'=> $paniers]);
    }


    public function validerPanierAction($id)
    {     
    	 $em = $this->getDoctrine()->getManager();
		 $panier = $em->getRepository(Paniers::class)->find($id);

         // inserer dans table vente
        $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
		$commandes = $repository->findCommandes($id);

		foreach ($commandes as $commande){
         $emP = $this->getDoctrine()->getManager();
		 $produit = $emP->getRepository(Produit::class)->find($commande->getProduit());
		 $Quantite = $produit->getQuantite();
		  
		  // verifier le stock
		 if ( $Quantite > $commande->getQuantite()) {
		 	$vente = new Ventes(); 

		    $vente->setPanier($panier);
		    $vente->setProduit($commande->getProduit());
		    $vente->setQuantite($commande->getQuantite());
		    $vente->setDateHoraire(new \DateTime("now"));

		    $emv = $this->getDoctrine()->getManager();
		    $emv->persist($vente);
            $emv->flush();

            // reduire le stock
            $produit = $emv->getRepository(Produit::class)->find($vente->getProduit()->getId());
            $Qte = $Quantite - ($commande->getQuantite());
            $produit->setQuantite($Qte);

            $emv->persist($produit);
            $emv->flush();
		 }
		}


		$panier->setEtat("valide");

		 $em->persist($panier);
         $em->flush();

  		return $this->redirectToRoute('list_panier');
    }

   

}