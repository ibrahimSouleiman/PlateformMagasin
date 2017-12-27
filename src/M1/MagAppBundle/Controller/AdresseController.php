<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
use M1\MagAppBundle\Entity\Adresses;
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/

use M1\MagAppBundle\Form\AdressesType;
use M1\MagAppBundle\Form\PaniersType;
/********************************/

use M1\MagAppBundle\Repository\PaniersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class AdresseController extends Controller
{

    public function choixadresseAction(Request $request)
    {
        $repositoryAdresse= $this->getDoctrine()->getRepository('M1MagAppBundle:Adresses');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $adresses = $repositoryAdresse->findByUtilisateur($user);



        return $this->render("M1MagAppBundle:Produit:choixadresse.html.twig", array('Adresses'=> $adresses,'user'=>$user));

    }

    public function addadresseAction(Request $request)
    {
        $adresse = new Adresses();

        $form  = $this->get('form.factory')->create(AdressesType::class, $adresse);
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $adresse->setUtilisateur($user);

            $em->persist($adresse);
            $em->flush();


            return $this->redirectToRoute('m1_mag_app_choixadressepage');
        }

        return $this->render('M1MagAppBundle:Produit:Form_Ajout_Adresse.html.twig', array(
            'form' => $form->createView(),
        ));
    }





}