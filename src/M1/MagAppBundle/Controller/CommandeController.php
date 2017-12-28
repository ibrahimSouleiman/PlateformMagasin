<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/
//use M1\MagAppBundle\Form\PaniersType;
/********************************/

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
   public function listCommandeAction($id)
    {
		//$Commandes = new Commandes();

		$repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
		$cmd = $repository->findCommandes($id);

		return $this->render("M1MagAppBundle:Magasinier:Cmd_Panier.html.twig",['Commandes'=> $cmd]);

    }


}