<?php

namespace FreeNote\FreeNoteBundle\Model;

interface fnCategoryInterface
{
    const FN_CATEGORY_ARTICLE_SLUG = 'artykuly';
    const FN_CATEGORY_NEWS_SLUG = 'aktualnosci';
    const FN_CATEGORY_EVENT_SLUG = 'wydarzenia';
    const FN_CATEGORY_ADVERTISEMENT_SLUG = 'ogloszenia';
    const FN_CATEGORY_BACKEND_artykuly_ALIAS = 'article';
    const FN_CATEGORY_BACKEND_aktualnosci_ALIAS = 'news';
    const FN_CATEGORY_BACKEND_wydarzenia_ALIAS = 'event';
    const FN_CATEGORY_BACKEND_ogloszenia_ALIAS = 'advertisement';
}
