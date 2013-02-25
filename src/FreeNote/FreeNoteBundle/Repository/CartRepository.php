<?php

namespace FreeNote\FreeNoteBundle\Repository;

use Sylius\Bundle\CartBundle\Entity\CartRepository as BaseCartRepository;

/**
 * Cart entity repository.
 */
class CartRepository extends BaseCartRepository
{
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->select('cart, item, variant, product, option, optionValue')
            ->leftJoin('item.variant', 'variant')
            ->leftJoin('variant.product', 'product')
            ->leftJoin('product.options', 'option')
            ->leftJoin('option.values', 'optionValue')
        ;
    }
}
