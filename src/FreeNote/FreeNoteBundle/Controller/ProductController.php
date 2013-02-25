<?php

namespace FreeNote\FreeNoteBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 */
class ProductController extends ResourceController
{
    public function listByTaxonAction(Request $request, $permalink)
    {
        $taxon = $this->findTaxonOr404($permalink);

        $paginator = $this
            ->getRepository()
            ->createByTaxonPaginator($taxon)
        ;

        $paginator->setCurrentPage($request->query->get('page', 1));
        $paginator->setMaxPerPage(9);

        $products = $paginator->getCurrentPageResults();

        return $this->renderResponse('listByTaxon.html', array(
            'taxon'     => $taxon,
            'products'  => $products,
            'paginator' => $paginator
        ));
    }

    private function findTaxonOr404($permalink)
    {
        $criteria = array('permalink' => $permalink);

        if (!$taxon = $this->getTaxonRepository()->findOneBy($criteria)) {
            throw new NotFoundHttpException('Requested taxon does not exist');
        }

        return $taxon;
    }

    private function getTaxonRepository()
    {
        return $this->get('sylius.repository.taxon');
    }
}
