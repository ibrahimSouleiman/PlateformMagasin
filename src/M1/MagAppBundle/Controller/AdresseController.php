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
use M1\MagAppBundle\Form\ProduitRechercheType;

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

        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $em = $this->getDoctrine()->getManager();

        $categories=$repositorycategory->findAll();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $adresses = $repositoryAdresse->findByUtilisateur($user);

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


        return $this->render("M1MagAppBundle:Produit:choixadresse.html.twig", array(
             'Adresses'=> $adresses,
             'user'=>$user,
             'Categories'=>$categories,
             'formsearch' => $formsearch->createView(),));

    }

    public function addadresseAction(Request $request)
    {

        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $em = $this->getDoctrine()->getManager();

        $categories=$repositorycategory->findAll();

        $adresse = new Adresses();

        $form  = $this->get('form.factory')->create(AdressesType::class, $adresse);
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();


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
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $adresse->setUtilisateur($user);

            $em->persist($adresse);
            $em->flush();


            return $this->redirectToRoute('m1_mag_app_choixadressepage');
        }

        return $this->render('M1MagAppBundle:Produit:Form_Ajout_Adresse.html.twig', array(
            'form' => $form->createView(),
            'Categories'=>$categories,
            'formsearch' => $formsearch->createView(),
        ));
    }





}