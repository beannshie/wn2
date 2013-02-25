<?php

namespace FreeNote\FreeNoteBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Administration dashboard controller.
 *
 */
class MainController extends Controller
{
    /**
     * Displays administration dashboard main panel.
     *
     * @return Response
     */
    public function indexAction()
    {
        $recentOrders = $this
            ->getOrderRepository()
            ->findBy(array(), array('updatedAt' => 'desc'), 5)
        ;

        $topOrders = $this
            ->getOrderRepository()
            ->findBy(array(), array('total' => 'desc'), 5)
        ;

        $newestUsers = $this
            ->getUserRepository()
            ->findBy(array(), array('id' => 'desc'), 10)
        ;

        return $this->render('FreeNoteBundle:Backend/Main:index.html.twig', array(
            'recentOrders' => $recentOrders,
            'topOrders'    => $topOrders,
            'newestUsers'  => $newestUsers
        ));
    }

    private function getOrderRepository()
    {
        return $this->get('sylius.repository.order');
    }

    private function getUserRepository()
    {
        return $this->get('sylius.repository.user');
    }
}
