<?php

namespace M1\MagAppBundle\Controller;

/***********Entities*********************/
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;
use M1\MagAppBundle\Entity\Utilisateurs;

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
use M1\MagAppBundle\Form\ProduitRechercheType;

use M1\MagAppBundle\Repository\CommandesRepository;

use Doctrine\ORM\Query\ResultSetMapping;


class CommandeController extends Controller
{

    public function listeAction(Request $request)
    {
        $categorie = new Categories();
        $repositoryCommande = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');

        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $em = $this->getDoctrine()->getManager();

        $categories=$repositorycategory->findAll();
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

        $rsm = new ResultSetMapping();

        $querys = $em->createNativeQuery("SELECT * FROM commandes",$rsm);

        $annes = $querys->getResult();

        $produit=array();

        if($annes!=null)
        {
            return $this->redirectToRoute('m1_mag_app_homepage', array(
                'Produit' => $produit
            ));
        }
        foreach ($paniers as $panier)
        {
            $commandes = $repositoryCommande->findByPanier($panier);

            array_push($paniersCommandes,array('PanierCommande'=>array(['Panier'=>$panier,"Commandes"=>$commandes])));

        }

        if ($request->isMethod('POST') ) {

            foreach ($paniers as $panier)
            {
                $choix=$_POST['choix'];

                if($choix=='30 Dernier jour')
                {

                }


                $commandes = $repositoryCommande->findByPanier($panier);

                array_push($paniersCommandes,array('PanierCommande'=>array(['Panier'=>$panier,"Commandes"=>$commandes])));

            }

            return $this->redirectToRoute('m1_mag_app_listecommandepage',array('PaniersCommandes'=>$paniersCommandes));
        }

        return $this->render('M1MagAppBundle:Produit:Liste_Commande.html.twig',array(
                    'PaniersCommandes'=>$paniersCommandes,
                    'Annes'=>$annes,
                    'Categories'=>$categories,
                    'formsearch' => $formsearch->createView(),));
    }


    public function viewcommandeAction(Request $request,$id)
    {

        $categorie = new Categories();
        $repositoryCommande = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
        $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');

        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $em = $this->getDoctrine()->getManager();

        $categories=$repositorycategory->findAll();
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

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $commandes = $repositoryCommande->findByPanier($id);

        $panier = $repositoryPanier->findOneById($id);



        return $this->render('M1MagAppBundle:Produit:detail_Commande.html.twig',array(
            'Commandes'=>$commandes,
            'Panier' => $panier,
            'Categories'=>$categories,
            'formsearch' => $formsearch->createView(),));
    }



    public function listCommandeAction($id)
    {
		$repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Commandes');
		$cmd = $repository->findCommandes($id);
        $user = new Utilisateurs();
       // $user->setNom()->$cmd->getPanier()->getUtilisateur();
       // $client = $cmd->getPanier()->getUtilisateur();
		//return $this->render("M1MagAppBundle:Magasinier:Cmd_Panier.html.twig",['Commandes'=> $cmd, 'client' => $client]);
    
     return $this->render('M1MagAppBundle:Magasinier:Cmd_Panier.html.twig',array('Commandes'=>$cmd/*,'client'=>$user*/));
    }


}