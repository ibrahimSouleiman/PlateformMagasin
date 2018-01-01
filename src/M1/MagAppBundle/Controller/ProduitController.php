<?php

namespace M1\MagAppBundle\Controller;
/***********Entities*********************/
use M1\MagAppBundle\Entity\Adresses;
use M1\MagAppBundle\Entity\Commandes;
use M1\MagAppBundle\Entity\Produit;
use M1\MagAppBundle\Entity\Paniers;

/**************forms******************/
use M1\MagAppBundle\Form\PaniersType;
use M1\MagAppBundle\Form\ProduitRechercheType;
use M1\MagAppBundle\Form\ProduitType;
use M1\MagAppBundle\Form\CommandesType;
use M1\MagAppBundle\Form\ProduitSearchType;

/********************************/

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
/********************************/

class ProduitController extends Controller
{


    private function search(Request $request,$formsearch)
    {
        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $categories=$repositorycategory->findAll();

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




    }




    public function indexAction(Request $request)
{
/***************************/



/***************************/
    $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Produit');
    $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

    $categories=$repositorycategory->findAll();

    $produit=new Produit();
    $formsearch  = $this->get('form.factory')->create(ProduitRechercheType::class, $produit);
    $formsearch->handleRequest($request);


    // On récupère l'entité correspondante à l'id $id
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery(
        'SELECT p
    FROM M1MagAppBundle:Produit p
    WHERE p.quantite > :quantite'
    )->setParameter('quantite', 0);
    $produit = $query->getResult();
    //$produit = $repository->findBy(array('quantite'=>">0"));

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $produit) {
        throw new NotFoundHttpException("Produit Vide");
    }

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
    return $this->render('M1MagAppBundle:Produit:index.html.twig', array(
        'Produit' => $produit,
        'Categories'=>$categories,
        'formsearch' => $formsearch->createView(),
    ));

}

    /**
     *  #@Security("has_role('ROLE_ADMIN')")
     */
    public function detailAction(Request $request,$ref)
    {
        $repository = $this->getDoctrine()->getRepository('M1MagAppBundle:Produit');
        $repositoryPanier = $this->getDoctrine()->getRepository('M1MagAppBundle:Paniers');
        $repositorycategory = $this->getDoctrine()->getRepository('M1MagAppBundle:Categories');

        $categories=$repositorycategory->findAll();
        //recuperation de l'id de l'utisateur
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $produit=new Produit();
        $formsearch  = $this->get('form.factory')->create(ProduitRechercheType::class, $produit);
        $formsearch->handleRequest($request);

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

        $commande=new Commandes();
      //  $form = $this->createForm(CommandesType::class, $commande);

        $form = $this->createFormBuilder($commande)
            ->setMethod('POST')
//                ->setAction($this->generateUrl('setStock/'.$id))
            ->add('quantite',ChoiceType::class, array(
                   'choices' => array(array_combine(range(1,$produit->getQuantite()),range(1,$produit->getQuantite())))))
            ->add('save', SubmitType::class,array('label'=> 'Ajouter au Panier'))
            ->getForm();
        $form->handleRequest($request);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $produit) {
            throw new NotFoundHttpException("Produit Vide");
        }


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

                if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {

                    // Sinon on déclenche une exception « Accès interdit »
                    // return $this->redirectToRoute('lieu');

                    //  throw new AccessDeniedException('Accès limité aux auteurs.');


                    $em->persist($panier);
                    $em->flush();
                    $commande->setProduit($produit);
                    $commande->setPanier($panier);
                    $commande->setDateHoraireAjout(new \DateTime("now"));
                    $commande->setDateHoraireValide(new \DateTime());
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
                        'Produit' => $produit,
                        'formsearch' =>$formsearch->createView(),
                        'Categories'=>$categories,
                    ));
                }else{
                    return $this->redirectToRoute('login');
                }

        }
           return $this->render('M1MagAppBundle:Produit:detail.html.twig', array(
            'Produit' => $produit,
               'form'=> $form->createView(),
               'formsearch' =>$formsearch->createView(),
               'Categories'=>$categories,
        ));

    }

    /**
     * @param $nb
     */
    public  function getAllChoice($nb)
    {
        $array=[];

     /*   for ($i in $nb){

            $array
        }
*/
    }



    /**************************************************************************************************************/

    public function addAction(Request $request)
    {
    	$produit = new Produit();

        $form  = $this->get('form.factory')->create(ProduitType::class, $produit);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $produit->getImage()->upload();

             $em->persist($produit);
             $em->flush();

             $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

             return $this->redirectToRoute('saved_categorie', array('id' => $produit->getId()));
    }

    return $this->render('M1MagAppBundle:Magasinier:Form_Ajout_Produit.html.twig', array(
      'form' => $form->createView(),
    ));
    }

     public function listStockAction(Request $request)
    {
           $em = $this->getDoctrine()->getManager();
		   $produits = $em->getRepository(Produit::class)->findAll();

    $defaultData = array('message' => 'Type your message here');
    $form = $this->createFormBuilder($defaultData)
        ->add('name', TextType::class, array('required'=>false))
        ->add('ref', TextType::class, array('required'=>false))
        ->add('save', SubmitType::class,array('label'=> 'Recherche'))
        ->getForm();

       // $form->handleRequest($request);

     if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

        $em = $this->getDoctrine()->getManager();

        $data = $form->getData();
        $products = $em->getRepository(Produit::class)->findProduitByParametres($data);

    return $this->render("M1MagAppBundle:Magasinier:List_Stock.html.twig", array('form' => $form->createView(),'produits'=> $products));
   
    }

		//return $this->render("M1MagAppBundle:Magasinier:List_Stock.html.twig", ['produits'=> $produits]);

    return $this->render("M1MagAppBundle:Magasinier:List_Stock.html.twig", array('form' => $form->createView(),'produits'=> $produits));
   
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
