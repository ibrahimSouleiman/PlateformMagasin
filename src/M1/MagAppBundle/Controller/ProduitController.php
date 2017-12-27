<?php

namespace M1\MagAppBundle\Controller;
/***********Entities*********************/
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/
use M1\MagAppBundle\Form\PaniersType;
use M1\MagAppBundle\Form\ProduitType;
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
     *  #@Security("has_role('ROLE_ADMIN')")
     */
    public function detailAction(Request $request,$ref)
    {
        $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Produit');
        $repositoryUser = $this->getDoctrine()->getRepository('M1MagAppBundle:Utilisateurs');
        $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');

        //recuperation de l'id de l'utisateur
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        // On récupère l'entité correspondante à l'id $id
        $produit = $repository->findOneById($ref);


        $panier= $repositoryPanier->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));
        if($panier == null){

            $panier = new Paniers();
            $panier->setEtat("Actif");
            $panier->setUtilisateur($user);
            $panier->setDescription("Mon Premier Panier");
        }

        $form = $this->createForm(PaniersType::class, $panier);
        $form->handleRequest($request);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $produit) {
            throw new NotFoundHttpException("Produit Vide");
        }

        if ($form->isSubmitted() && $form->isValid()) {

                if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {

                    // Sinon on déclenche une exception « Accès interdit »
                    // return $this->redirectToRoute('lieu');

                    //  throw new AccessDeniedException('Accès limité aux auteurs.');


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
                    ));
                }else{
                    return $this->redirectToRoute('login');
                }

        }
           return $this->render('M1MagAppBundle:Produit:detail.html.twig', array(
            'Produit' => $produit, 'form'=> $form->createView()
        ));

    }

    public function voirmonpanierAction()
    {
         $repositoryCommande= $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
         $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $panier= $repositoryPanier->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));

        $commades = $repositoryCommande->findOneByPanier($panier);



       return $this->render("M1MagAppBundle:Produit:monpanier.html.twig", array('Commande'=> $commades,'user'=>$user->getId()));

    }

    /**************************************************************************************************************/

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
