<?php

namespace Wn\AssortmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WnAssortmentBundle:Default:index.html.twig', array('name' => $name));
    }
}
