<?php

namespace FreeNote\FreeNoteBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Frontend main controller.
 */
class MainController extends Controller
{
    /**
     * Main page.
     *
     * @return Response
     */
    public function indexAction()
    {
        $recentProducts = $this
            ->getProductRepository()
            ->findBy(array(), array('updatedAt' => 'desc'), 8)
        ;

        return $this->render('FreeNoteBundle:Frontend/Main:index.html.twig', array(
            'recentProducts' => $recentProducts,
        ));
    }

    public function aboutAction()
    {
        return $this->render('FreeNoteBundle:Frontend/Main:about.html.twig');
    }

    private function getProductRepository()
    {
        return $this->get('sylius.repository.product');
    }
}
