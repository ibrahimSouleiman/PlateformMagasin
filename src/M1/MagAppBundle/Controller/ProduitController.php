<?php

namespace M1\MagAppBundle\Controller;
/***********Entities*********************/
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/
use M1\MagAppBundle\Form\PaniersType;

/********************************/

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/********************************/

class ProduitController extends Controller
{
    public function indexAction()
{
/***************************/



/***************************/
    $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Produit');

    // On récupère l'entité correspondante à l'id $id
    $produit = $repository->findAll();

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $produit) {
        throw new NotFoundHttpException("Produit Vide");
    }


    return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
        'Produit' => $produit
    ));

}

    /**
     *  @Security("has_role('ROLE_USER')")
     */
    public function detailAction(Request $request,$ref)
    {
        $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Produit');
        $em = $this->getDoctrine()->getManager();
        // On récupère l'entité correspondante à l'id $id
        $produit = $repository->findOneById($ref);
        $panier= new Paniers();
        $form = $this->createForm(PaniersType::class, $panier);
        $form->handleRequest($request);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $produit) {
            throw new NotFoundHttpException("Produit Vide");
        }

        if ($form->isSubmitted() && $form->isValid()) {

            //    if (!$this->get('security.authorization_checkert')->isGranted('ROLE_AUTEUR')) {

                // Sinon on déclenche une exception « Accès interdit »
               // return $this->redirectToRoute('lieu');

              //  throw new AccessDeniedException('Accès limité aux auteurs.');
                /*
                $panier->setEtat("Actif");
                $panier->setDescription("Mon Premier Panier");
                $em->persist($panier);
                $em->flush();
                $commande = new Commandes();
                $commande->setProduit($produit);
                $commande->setPanier($panier);
                $commande->setQuantite(5);

                $em->persist($commande);
                $em->flush();

                return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                    'Produit' => $produit
                ));*/

        }
           return $this->render('M1MagAppBundle:Produit:detail.html.twig', array(
            'Produit' => $produit, 'form'=> $form->createView()
        ));

    }


}
