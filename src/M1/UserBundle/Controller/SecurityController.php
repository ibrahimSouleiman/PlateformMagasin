<?php

namespace M1\UserBundle\Controller;

use M1\MagAppBundle\Entity\Utilisateurs;
use M1\MagAppBundle\Form\UtilisateursType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login",name="login")
     *
     */
    public function loginAction(Request $request)
    {



            // Si le visiteur est déjà identifié, on le redirige vers l'accueil
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {


                if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                  //  return $this->redirectToRoute('m1_mag_app_homepage');
                }else if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
                   // return $this->redirectToRoute('register');

                }

            }

            // Le service authentication_utils permet de récupérer le nom d'utilisateur
            // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
            // (mauvais mot de passe par exemple)
            $authenticationUtils = $this->get('security.authentication_utils');

            return $this->render('M1UserBundle:Security:login.html.twig', array(
                'last_username' => $authenticationUtils->getLastUsername(),
                'error'         => $authenticationUtils->getLastAuthenticationError(),
            ));




    }

    /**
     * @Route("/logout",name="logout")
     *
     */
   public function  logoutAction()
   {

   }

    /**
     * @Route("/register",name="register")
     *
     */
    public function  registerAction(Request $request)
    {
      $em=$this->getDoctrine()->getManager();
      $user=new Utilisateurs();
      $form=$this->createForm(UtilisateursType::class,$user);

      $form->handleRequest($request);
      $user->setSalt('');
        $user->setRoles(array('ROLE_USER'));
        $user->setAdresse('');

      if($form->isValid()&& $form->isSubmitted())
      {
          //re
          $em->persist($user);
          $em->flush();
          return $this->redirectToRoute('login');

      }


      return $this->render('M1UserBundle:Security:register.html.twig',array('form'=>$form->createView()));

    }

}
