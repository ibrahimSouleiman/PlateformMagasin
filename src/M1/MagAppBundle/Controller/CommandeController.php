<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/
//use M1\MagAppBundle\Form\PaniersType;
/********************************/


use M1\MagAppBundle\Entity\Categories;
use M1\MagAppBundle\Form\CategoriesType;
	
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

//use M1\MagAppBundle\Repository\PaniersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use M1\MagAppBundle\Repository\CommandesRepository;




class CommandeController extends Controller
{

    public function listeAction(Request $request)
    {
        $categorie = new Categories();
        $repositoryCommande = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $query = $em->createQuery(
                        'SELECT p
                         FROM M1MagAppBundle:Paniers p
                         WHERE p.utilisateur = :iduser
                          and p.etat=:valider or p.etat=:traite'
        )->setParameter('iduser', $user->getId())
            ->setParameter('valider', 'valider')
            ->setParameter('traite', 'traité');
        $paniers = $query->getResult();

        $paniersCommandes = array();

        foreach ($paniers as $panier)
        {
            $commandes = $repositoryCommande->findByPanier($panier);

            array_push($paniersCommandes,array('PanierCommande'=>array(['Panier'=>$panier,"Commandes"=>$commandes])));

        }

        if ($request->isMethod('POST') ) {
            $em->persist($categorie);
            $em->flush();


            return $this->redirectToRoute('m1_mag_app_listecommandepage', array('id' => $categorie->getId()));
        }

        return $this->render('M1MagAppBundle:Produit:Liste_Commande.html.twig',array('PaniersCommandes'=>$paniersCommandes));
    }


public function listCommandeAction($id)
    {
		//$Commandes = new Commandes();

		$repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
		$cmd = $repository->findCommandes($id);

		return $this->render("M1MagAppBundle:Magasinier:Cmd_Panier.html.twig",['Commandes'=> $cmd]);

    }



}