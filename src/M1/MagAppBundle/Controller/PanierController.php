<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
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


class PanierController extends Controller
{
 public function listPanierAction()
    {
           //$em = $this->getDoctrine()->getManager();
		   //$paniers = $em->getRepository(Paniers::class)->findPanierValider();

		   $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');
		   $paniers = $repository->findPanierValider();

		return $this->render("M1MagAppBundle:Magasinier:List_Panier.html.twig", ['paniers'=> $paniers]);
   
    }
}