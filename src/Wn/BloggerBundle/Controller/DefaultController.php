<?php

namespace Wn\BloggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WnBloggerBundle:Default:index.html.twig', array('name' => $name));
    }
}
