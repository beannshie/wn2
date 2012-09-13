<?php

namespace Wn\SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WnSalesBundle:Default:index.html.twig', array('name' => $name));
    }
}
