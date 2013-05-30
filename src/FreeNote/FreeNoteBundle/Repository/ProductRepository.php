<?php

namespace FreeNote\FreeNoteBundle\Repository;

use Sylius\Bundle\AssortmentBundle\Entity\CustomizableProductRepository;
use Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface;

/**
 * Product repository.
 */
class ProductRepository extends CustomizableProductRepository
{
    public function createByTaxonPaginator(TaxonInterface $taxon)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();

        $queryBuilder
            ->innerJoin('product.taxons', 'taxon')
            ->andWhere('taxon = :taxon')
            ->setParameter('taxon', $taxon)
        ;

        return $this->getPaginator($queryBuilder);
    }

    public function findTopSelled($limit)
    {
        //TODO - implement toto
        $queryBuilder = $this->getCollectionQueryBuilder();

        $queryBuilder
            ->leftJoin('product.variants', 'variant')
            ->orderBy('variant.price', 'desc')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
