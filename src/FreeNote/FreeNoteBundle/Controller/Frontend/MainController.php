<?php

namespace FreeNote\FreeNoteBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

/**
 * Main boxes controller.
 */
class MainController extends Controller
{
    /**
     * Down adverts box.
     *
     * @return Response
     */
    public function downAdvertAction()
    {
        $content = <<<EOF
<img src="/assets/img/todelete/reklama_graficzna_ikony.jpg" alt="Wolna Nuta" width="160" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="/assets/img/todelete/ryc159.jpg" alt="Wolna Nuta" width="247" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="/assets/img/todelete/verato-1024x813.jpg" alt="Wolna Nuta" width="210" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="/assets/img/todelete/logo-shodgan.jpg" alt="Wolna Nuta" width="380" />
</br></br>
EOF;

        return $this->render('FreeNoteBundle:Frontend/Main:downAdvert.html.twig', array(
            'content' => $content,
        ));
    }

    /**
     * Shop box.
     *
     * @return Response
     */
    public function shopBoxAction()
    {
        $recentProducts = $this
            ->getProductRepository()
            ->findBy(array(), array('updatedAt' => 'desc'), 3)
        ;

        $mostBuyProducts = $this
            ->getProductRepository()
            ->findTopSelled(3)
        ;

        return $this->render('FreeNoteBundle:Frontend/Main:shopBox.html.twig', array(
            'recentProducts' => $recentProducts,
            'mostBuyProducts' => $mostBuyProducts,
        ));

    }

    private function getProductRepository()
    {
        return $this->get('sylius.repository.product');
    }
}
