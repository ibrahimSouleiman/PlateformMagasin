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
use M1\MagAppBundle\Form\ProduitRechercheType;

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

    public function voirmonpanierAction(Request $request)
    {
        $repositoryCommande= $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
        $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');
        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $categories=$repositorycategory->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $panier= $repositoryPanier->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));

        $commandes = $repositoryCommande->findByPanier($panier);
        $em = $this->getDoctrine()->getManager();

        $produit=new Produit();
        $formsearch  = $this->get('form.factory')->create(ProduitRechercheType::class, $produit);
        $formsearch->handleRequest($request);

        if ($formsearch->isSubmitted()) {


            $choix=$_POST['categorie'];
            $data = $formsearch->getData();

            $name=$data->getNom();

            if($choix=="Tous")
            {
                if($name!="")
                {
                    $categorie=$repositorycategory->findOneById($choix);

                    $query = $em->createQuery(
                        'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.nom LIKE :nom 
                 and p.quantite > :quantite'
                    )->setParameter('quantite', 0)
                        ->setParameter('nom', $name.'%');

                    $produit = $query->getResult();
                    return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                        'Produit' => $produit,
                        'Categories'=>$categories,
                        'formsearch' => $formsearch->createView(),
                    ));
                }else{

                    $categorie=$repositorycategory->findOneById($choix);

                    $query = $em->createQuery(
                        'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.quantite > :quantite'
                    )->setParameter('quantite', 0);

                    $produit = $query->getResult();
                    return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                        'Produit' => $produit,
                        'Categories'=>$categories,
                        'formsearch' => $formsearch->createView(),
                    ));

                }

            }

            if($name != "")
            {

                $categorie=$repositorycategory->findOneById($choix);

                $query = $em->createQuery(
                    'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.categorie = :categorie
                 and p.nom LIKE :nom
                 and p.quantite > :quantite'
                )->setParameter('categorie', $categorie)
                    ->setParameter('nom', $name.'%')
                    ->setParameter('quantite', 0);
                $produit = $query->getResult();
                return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                    'Produit' => $produit,
                    'Categories'=>$categories,
                    'formsearch' => $formsearch->createView(),
                ));
            }else{

                $categorie=$repositorycategory->findOneById($choix);

                $query = $em->createQuery(
                    'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.categorie = :categorie
                 and p.quantite > :quantite'
                )->setParameter('categorie', $categorie)
                    ->setParameter('quantite', 0);
                $produit = $query->getResult();
                return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                    'Produit' => $produit,
                    'Categories'=>$categories,
                    'formsearch' => $formsearch->createView(),
                ));
            }


        }

        if ($request->isMethod('post')){


            foreach ($commandes as $commande){

                $choix=$_POST[$commande->getId()];
                $commande->setQuantite($choix);

                $em->flush();
                return $this->redirectToRoute('m1_mag_app_choixadressepage');


            }

        }

        return $this->render("M1MagAppBundle:Produit:monpanier.html.twig", array(
            'commandes'=> $commandes,
            'user'=>$user->getId(),
            'Panier' =>$panier,
            'Categories'=>$categories,
            'formsearch' => $formsearch->createView()));

    }

    public function supprimerPanierAction($id)
    {
        $repositoryCommande= $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
        $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $panier= $repositoryPanier->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));

        $commandes = $repositoryCommande->findByPanier($panier);
        $em = $this->getDoctrine()->getManager();

        $commande=$repositoryCommande->findOneById($id);

        if($commande!=null) {
            $em->remove($commande);
            $em->flush();
        }
        return $this->redirectToRoute("m1_mag_app_voirPanierpage", array('commandes'=> $commandes,'Panier' =>$panier));

    }

    public function  sendmailAction()
    {

      $message = \Swift_Message::newInstance()
          ->setSubject("TEST OBJECT")
          ->setFrom("ibroleonardo@gmail.com")
          ->setTo('ibroleonardo@gmail.com')
          ->setCharset('utf-8')
          ->setContentType('text/html')
          ->setBody("fsdfsdfdsfs");

      $this->get('mailer')->send($message);

        return $this->redirectToRoute('m1_mag_app_homepage');


    }




    public function ajouterPanierAction($ref)
    {
        $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Produit');
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
            $panier->setDateHoraireValide(new \DateTime());

        }

        $commande=new Commandes();
        //  $form = $this->createForm(CommandesType::class, $commande);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $produit) {
            throw new NotFoundHttpException("Produit Vide");
        }


            if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {

                // Sinon on déclenche une exception « Accès interdit »
                // return $this->redirectToRoute('lieu');

                //  throw new AccessDeniedException('Accès limité aux auteurs.');


                $em->persist($panier);
                $em->flush();
                $commande->setProduit($produit);
                $commande->setPanier($panier);
                $commande->setQuantite(1);
                $commande->setDateHoraireAjout(new \DateTime("now"));
                $commande->setEtat("Initial");
                $em->persist($commande);
                $em->flush();
                $query = $em->createQuery(
                    'SELECT p
                         FROM M1MagAppBundle:Produit p
                         WHERE p.quantite > :quantite'
                )->setParameter('quantite', 0);
                $produit = $query->getResult();
                return $this->redirectToRoute('m1_mag_app_homepage', array(
                    'Produit' => $produit
                ));
            }else{
                return $this->redirectToRoute('login');
            }




    }
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
        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $categories=$repositorycategory->findAll();


        $produit=new Produit();
        $formsearch  = $this->get('form.factory')->create(ProduitRechercheType::class, $produit);
        $formsearch->handleRequest($request);



        $user = $this->get('security.token_storage')->getToken()->getUser();
        $panier= $repositoryPanier->findOneBy(array('utilisateur'=>$user,'etat' =>'Actif'));
        $commandes = $repositoryCommande->findByPanier($panier);
        $em = $this->getDoctrine()->getManager();

        if ($formsearch->isSubmitted()) {


            $choix=$_POST['categorie'];
            $data = $formsearch->getData();

            $name=$data->getNom();

            if($choix=="Tous")
            {
                if($name!="")
                {
                    $categorie=$repositorycategory->findOneById($choix);

                    $query = $em->createQuery(
                        'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.nom LIKE :nom 
                 and p.quantite > :quantite'
                    )->setParameter('quantite', 0)
                        ->setParameter('nom', $name.'%');

                    $produit = $query->getResult();
                    return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                        'Produit' => $produit,
                        'Categories'=>$categories,
                        'formsearch' => $formsearch->createView(),
                    ));
                }else{

                    $categorie=$repositorycategory->findOneById($choix);

                    $query = $em->createQuery(
                        'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.quantite > :quantite'
                    )->setParameter('quantite', 0);

                    $produit = $query->getResult();
                    return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                        'Produit' => $produit,
                        'Categories'=>$categories,
                        'formsearch' => $formsearch->createView(),
                    ));

                }

            }

            if($name != "")
            {

                $categorie=$repositorycategory->findOneById($choix);

                $query = $em->createQuery(
                    'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.categorie = :categorie
                 and p.nom LIKE :nom
                 and p.quantite > :quantite'
                )->setParameter('categorie', $categorie)
                    ->setParameter('nom', $name.'%')
                    ->setParameter('quantite', 0);
                $produit = $query->getResult();
                return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                    'Produit' => $produit,
                    'Categories'=>$categories,
                    'formsearch' => $formsearch->createView(),
                ));
            }else{

                $categorie=$repositorycategory->findOneById($choix);

                $query = $em->createQuery(
                    'SELECT p
                 FROM M1MagAppBundle:Produit p
                 WHERE p.categorie = :categorie
                 and p.quantite > :quantite'
                )->setParameter('categorie', $categorie)
                    ->setParameter('quantite', 0);
                $produit = $query->getResult();
                return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
                    'Produit' => $produit,
                    'Categories'=>$categories,
                    'formsearch' => $formsearch->createView(),
                ));
            }


        }



        if ($request->isMethod('POST') ) {
            $em = $this->getDoctrine()->getManager();
            $today = date("Y-m-d H:i:s");

            $panier->setEtat("validé");
            $panier->setDateHoraireValide(new \DateTime("now"));


            foreach ($commandes as $commande){


                $produit = $em->getRepository(Produit::class)->find($commande->getProduit());
                $Quantite = $produit->getQuantite();

                // verifier le stock
                if ( $Quantite >= $commande->getQuantite()) {


                    // reduire le stock

                    $Qte = $Quantite - ($commande->getQuantite());
                    $produit->setQuantite($Qte);
                    $em->persist($produit);
                    $em->flush();

                    $commande->setEtat('traité');
                    $em->persist($commande);
                    $em->flush();

                }
                else
                {
                    $commande->setEtat('non traité');
                    $em->flush();
                }
            }


            $em->flush();

            return $this->redirectToRoute('m1_mag_app_homepage');

        }

        return $this->render("M1MagAppBundle:Produit:valide_panier.html.twig", array(
            'commandes'=> $commandes,
            'Adresse' => $panier->getAdresse(),
            'user'=>$user->getId(),
            'Categories'=>$categories,
            'formsearch' => $formsearch->createView()));

    }
/*****************************************************************************************/
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
   public function listPanierAction(Request $request)
    {
           $Panier = new Paniers();

		   $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');
		   $paniers = $repository->findPanierValider();

   return $this->render("M1MagAppBundle:Magasinier:List_Panier.html.twig", ['paniers'=> $paniers]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
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
		 if ( $Quantite >= $commande->getQuantite()) {
		 	$vente = new Ventes(); 

		    $vente->setPanier($panier);
		    $vente->setProduit($commande->getProduit());
		    $vente->setQuantite($commande->getQuantite());
		    $vente->setDateHoraire(new \DateTime("now"));

		    $emv = $this->getDoctrine()->getManager();
		    $emv->persist($vente);
        $emv->flush();



        $commande->setEtat('traité');
        $emv->persist($commande);
        $emv->flush();

		 }
     else
     {
        $commande->setEtat('non traité');
        $em->persist($commande);
        $em->flush();
     }
		}

    // normalement traité
		$panier->setEtat("traité");

		 $em->persist($panier);
         $em->flush();

  		return $this->redirectToRoute('list_panier');
    }

   

}