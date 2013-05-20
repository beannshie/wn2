<?php

namespace FreeNote\FreeNoteBundle\Model;

final class fnUserParameters
{
    const FN_ROLE_USER = 'ROLE_USER';
    const FN_ROLE_BUYER = 'ROLE_BUYER';
    const FN_ROLE_BUYER_CO = 'ROLE_BUYER_CO';
    const FN_ROLE_SELLER = 'ROLE_SELLER';
    const FN_ROLE_ADMIN = 'ROLE_ADMIN';
    const FN_ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    const FN_ROLE_USER_SLUG = 'user';
    const FN_ROLE_BUYER_SLUG = 'buyer';
    const FN_ROLE_BUYER_CO_SLUG = 'buyerCo';
    const FN_ROLE_SELLER_SLUG = 'seller';

    private static $roleSlugArray = array(
        self::FN_ROLE_USER_SLUG => self::FN_ROLE_USER,
        self::FN_ROLE_BUYER_SLUG => self::FN_ROLE_BUYER,
        self::FN_ROLE_BUYER_CO_SLUG => self::FN_ROLE_BUYER_CO,
        self::FN_ROLE_SELLER_SLUG => self::FN_ROLE_SELLER,

    );

    public static function getRoleBySlug($slug)
    {
        return self::$roleSlugArray[$slug];
    }
}
