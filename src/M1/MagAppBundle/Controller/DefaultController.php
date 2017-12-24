<?php

namespace M1\MagAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('M1MagAppBundle:Default:index.html.twig');
    }
}
