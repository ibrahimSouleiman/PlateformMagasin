<?php

namespace M1\MagAppBundle\Controller;

use M1\MagAppBundle\Entity\Paniers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use M1\MagAppBundle\Form\CategoriesType;
use Symfony\Component\HttpFoundation\Request;


class CategorieController extends Controller
{


    public function listPanierAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paniers = $em->getRepository(Paniers::class)->findAll();

        return $this->render("M1MagAppBundle:Magasinier:List_Stock.html.twig", ['paniers'=> $paniers]);

    }

}