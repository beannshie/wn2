<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Repository;

use Sylius\Bundle\CartBundle\Entity\CartRepository as BaseCartRepository;

/**
 * Cart entity repository.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
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
