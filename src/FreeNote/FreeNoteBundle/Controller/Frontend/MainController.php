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
            ->findBy(array(), array('createdAt' => 'desc'), 3)
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

    /**
     * News/articles/events box.
     *
     * @return Response
     */
    public function categoriesBoxAction()
    {
        $recentNews = $this
            ->getAliasRepository(fnCategoryInterface::FN_CATEGORY_BACKEND_aktualnosci_ALIAS)
            ->findBy(array(), array('createdAt' => 'desc'), 3)
        ;

        $recentEvents = $this
            ->getAliasRepository(fnCategoryInterface::FN_CATEGORY_BACKEND_wydarzenia_ALIAS)
            ->findBy(array(), array('createdAt' => 'desc'), 3)
        ;

        $recentArticles = $this
            ->getAliasRepository(fnCategoryInterface::FN_CATEGORY_BACKEND_artykuly_ALIAS)
            ->findBy(array(), array('createdAt' => 'desc'), 3)
        ;

        return $this->render('FreeNoteBundle:Frontend/Main:categoriesBox.html.twig', array(
            'recentNews' => $recentNews,
            'recentEvents' => $recentEvents,
            'recentArticles' => $recentArticles,
        ));
    }

    /**
     * Mosr downloaded box.
     *
     * @return Response
     */
    public function mostDownloadedBoxAction()
    {
        //TODO - -implement
        $mostDownloaded = array(1,2,3,4);

        return $this->render('FreeNoteBundle:Frontend/Main:mostDownloadedBox.html.twig', array(
            'mostDownloaded' => $mostDownloaded,
        ));
    }

    private function getProductRepository()
    {
        return $this->get('sylius.repository.product');
    }

    private function getAliasRepository($alias)
    {
        return $this->get('free_note.repository.'.$alias.'_entry');
    }
}
