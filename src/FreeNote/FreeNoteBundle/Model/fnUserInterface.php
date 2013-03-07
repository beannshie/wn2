<?php

namespace FreeNote\FreeNoteBundle\Model;

interface fnUserInterface
{
    const FN_ROLE_USER = 'ROLE_USER';
    const FN_ROLE_BUYER = 'ROLE_BUYER';
    const FN_ROLE_BUYER_CO = 'ROLE_BUYER_CO';
    const FN_ROLE_SELLER = 'ROLE_SELLER';
    const FN_ROLE_ADMIN = 'ROLE_ADMIN';
    const FN_ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
}
