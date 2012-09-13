<?php

namespace Wn\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WnCartBundle:Default:index.html.twig', array('name' => $name));
    }
}
