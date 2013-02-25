<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wn\WnBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Menu builder.
 */
class Builder extends ContainerAware
{
    /**
     * Builds frontend main menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function frontendMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('Sklep', array('route' => 'free_note_core_frontend'));
        $menu->addChild('Produkty', array('route' => 'free_note_product_list'));

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $categoryManager = $this->container->get('sylius_categorizer.manager.category');
        $articleCategories = $categoryManager->findCategories('articles');

        $child = $menu->addChild('Artykuły', $childOptions);
        $child->addChild('Najnowsze wpisy', array('route' => 'free_note_post_list'));
        $this->addDivider($child);

        foreach ($articleCategories as $category) {
            $child->addChild($category->getName(), array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'articles',
                    'slug'  => $category->getSlug()
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }

        $newsCategories = $categoryManager->findCategories('news');

        $child = $menu->addChild('Aktualności', $childOptions);
        $child->addChild('Najnowsze wpisy', array('route' => 'free_note_post_list'));
        $this->addDivider($child);

        foreach ($newsCategories as $category) {
            $child->addChild($category->getName(), array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'news',
                    'slug'  => $category->getSlug()
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }

        $eventCategories = $categoryManager->findCategories('events');

        $child = $menu->addChild('Wydarzenia', $childOptions);
        $child->addChild('Najnowsze wpisy', array('route' => 'free_note_post_list'));
        $this->addDivider($child);

        foreach ($eventCategories as $category) {
            $child->addChild($category->getName(), array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'events',
                    'slug'  => $category->getSlug()
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }

        $advertisementCategories = $categoryManager->findCategories('advertisements');

        $child = $menu->addChild('Ogłoszenia', $childOptions);
        $child->addChild('Najnowsze wpisy', array('route' => 'free_note_post_list'));
        $this->addDivider($child);

        foreach ($advertisementCategories as $category) {
            $child->addChild($category->getName(), array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'advertisements',
                    'slug'  => $category->getSlug()
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }

        $menu->addChild('O nas', array('route' => 'free_note_about'));
        $menu->addChild('Koszyk', array('route' => 'sylius_cart_summary'));

        return $menu;
    }

    /**
     * Builds frontend side menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function frontendSidebarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav nav-list'),
            'labelAttributes'    => array('class' => 'nav-header')
        );

        $child = $menu->addChild('Wolna Nuta', $childOptions);
        $child->addChild('O nas', array(
            'route'           => 'free_note_about',
            'labelAttributes' => array('icon' => 'icon-info-sign')
        ));

        $child = $menu->addChild('Przeglądaj produkty', $childOptions);

        $child->addChild('Wszystkie', array(
            'route'           => 'free_note_product_list',
            'labelAttributes' => array('icon' => 'icon-tags')
        ));

        $taxonomies = $this
            ->getTaxonomyRepository()
            ->findAll()
        ;

        foreach ($taxonomies as $taxonomy) {
            $child = $menu->addChild($taxonomy->getName(), $childOptions);

            foreach ($taxonomy->getTaxons() as $taxon) {
                $child->addChild($taxon->getName(), array(
                    'route'           => 'free_note_product_list_by_taxon',
                    'routeParameters' => array('permalink' => $taxon->getPermalink()),
                    'labelAttributes' => array('icon' => ' icon-caret-right')
                ));
            }
        }

        $child = $menu->addChild('Moje konto', $childOptions);
        if ($this->container->get('security.context')->isGranted('ROLE_USER')) {
            $child->addChild('Wyloguj', array(
                'route' => 'fos_user_security_logout',
                'labelAttributes' => array('icon' => 'icon-off')
            ));
        } else {
            $child->addChild('Zarejestruj', array(
                'route' => 'fos_user_registration_register',
                'labelAttributes' => array('icon' => 'icon-plus')
            ));
            $child->addChild('Zaloguj', array(
                'route' => 'fos_user_security_login',
                'labelAttributes' => array('icon' => 'icon-user')
            ));
        }

        if ($this->container->get('security.context')->isGranted('ROLE_SYLIUS_ADMIN')) {
            $child->addChild('Panel administratora', array(
                'route' => 'free_note_core_backend',
                'labelAttributes' => array('icon' => 'icon-lock')
            ));
        }

        return $menu;
    }

    /**
     * Builds backend main menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function backendMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('Panel', array('route' => 'free_note_core_backend'));

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $this->addTaxonomiesMenu($menu, $childOptions);
        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addCustomersMenu($menu, $childOptions);
        $this->addConfigurationMenu($menu, $childOptions);
        $this->addArticleMenu($menu, $childOptions);
        $this->addNewsMenu($menu, $childOptions);
        $this->addEventMenu($menu, $childOptions);
        $this->addAdvertisementMenu($menu, $childOptions);

        $menu->addChild('Przejdź do <strong>strony głównej</strong>', array('route' => 'free_note_core_frontend'));

        return $menu;
    }

    /**
     * Builds backend side menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function backendSidebarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav nav-list'),
            'labelAttributes'    => array('class' => 'nav-header')
        );

        $this->addTaxonomiesMenu($menu, $childOptions);
        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addCustomersMenu($menu, $childOptions);
        $this->addConfigurationMenu($menu, $childOptions);

        $child = $menu->addChild('Administracja', $childOptions);
        $child->addChild('Logout', array(
            'route' => 'fos_user_security_logout',
            'labelAttributes' => array('icon' => 'icon-off')
        ));

        return $menu;
    }

    /**
     * Adds assortment menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addAssortmentMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Asortyment', $childOptions);

        // Products.
        $child->addChild('Dodaj produkt', array(
            'route'           => 'free_note_backend_product_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista produktów', array(
            'route'           => 'free_note_backend_product_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
        $child->addChild('Inventory levels', array(
            'route'           => 'free_note_backend_stockable_list',
            'labelAttributes' => array('icon' => 'icon-tasks')
        ));

        $this->addDivider($child);

        $child->addChild('Zarządzaj opcjami', array(
            'route'           => 'free_note_backend_option_list',
            'labelAttributes' => array('icon' => 'icon-random')
        ));
        $child->addChild('Dostosuj właściwości', array(
            'route'           => 'free_note_backend_property_list',
            'labelAttributes' => array('icon' => 'icon-th-large')
        ));
        $child->addChild('Prototypy', array(
            'route'           => 'free_note_backend_prototype_list',
            'labelAttributes' => array('icon' => 'icon-cogs')
        ));
    }

    /**
     * Adds sales menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addSalesMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Zamówienia', $childOptions);

        $child->addChild('Bieżące zamówienia', array(
            'route'           => 'free_note_backend_order_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
        $child->addChild('Dodaj zamówienie', array(
            'route'           => 'free_note_backend_order_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Shipments', array(
            'route'           => 'free_note_backend_shipment_list',
            'labelAttributes' => array('icon' => 'icon-plane')
        ));
    }

    /**
     * Adds article menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addArticleMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Artykuły', $childOptions);

        $child->addChild('Dodaj kategorię', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'articles'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'articles'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        $child->addChild('Dodaj wpis', array(
            'route' => 'free_note_backend_post_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista wpisów', array(
            'route'           => 'free_note_backend_post_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds news menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addNewsMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Aktualności', $childOptions);

        $child->addChild('Dodaj kategorię', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'news'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'news'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        $child->addChild('Dodaj wpis', array(
            'route' => 'free_note_backend_post_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista wpisów', array(
            'route'           => 'free_note_backend_post_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds events menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addEventMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Wydarzenia', $childOptions);

        $child->addChild('Dodaj kategorię', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'events'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'events'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        $child->addChild('Dodaj wpis', array(
            'route' => 'free_note_backend_post_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista wpisów', array(
            'route'           => 'free_note_backend_post_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds advertisement menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addAdvertisementMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Ogłoszenia', $childOptions);

        $child->addChild('Dodaj kategorię', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'advertisements'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'advertisements'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        $child->addChild('Dodaj wpis', array(
            'route' => 'free_note_backend_post_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista wpisów', array(
            'route'           => 'free_note_backend_post_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }


    /**
     * Adds customers menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addCustomersMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Klienci', $childOptions);

        $child->addChild('Książka adresowa', array(
            'route' => 'free_note_backend_address_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
        $child->addChild('Dodaj adres', array(
            'route' => 'free_note_backend_address_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista użytkowników', array(
            'route' => 'free_note_backend_user_list',
            'labelAttributes' => array('icon' => 'icon-user')
        ));
    }

    /**
     * Adds taxonomies menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addTaxonomiesMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Kategoryzacja', $childOptions);

        $child->addChild('Dodaj kategorię', array(
            'route' => 'free_note_backend_taxonomy_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route' => 'free_note_backend_taxonomy_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds configuration menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addConfigurationMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Konfiguracja', $childOptions);

        $child->addChild('Ustawienia ogólne', array(
            'route' => 'free_note_backend_settings_general_configure',
            'labelAttributes' => array('icon' => 'icon-cogs')
        ));

        $this->addDivider($child);

//        $child->addChild('Manage countries and provinces', array(
//            'route' => 'free_note_backend_country_list',
//            'labelAttributes' => array('icon' => 'icon-flag')
//        ));
//        $child->addChild('Manage zones', array(
//            'route' => 'free_note_backend_zone_list',
//            'labelAttributes' => array('icon' => 'icon-globe')
//        ));
//
//        $this->addDivider($child);

//        $child->addChild('Configure taxation', array(
//            'route' => 'free_note_backend_settings_taxation_configure',
//            'labelAttributes' => array('icon' => 'icon-cogs')
//        ));
        $child->addChild('Kategorie podatków', array(
            'route' => 'free_note_backend_tax_category_list',
            'labelAttributes' => array('icon' => 'icon-tasks')
        ));
        $child->addChild('Stawki podatkowe', array(
            'route' => 'free_note_backend_tax_rate_list',
            'labelAttributes' => array('icon' => 'icon-adjust')
        ));

        $this->addDivider($child);

        $child->addChild('Kategorie dostaw', array(
            'route' => 'free_note_backend_shipping_category_list',
            'labelAttributes' => array('icon' => 'icon-forward')
        ));
        $child->addChild('Lista sposobów dostawy', array(
            'route' => 'free_note_backend_shipping_method_list',
            'labelAttributes' => array('icon' => 'icon-envelope')
        ));
    }

    /**
     * Adds divider menu item.
     *
     * @param ItemInterface $item
     * @param Boolean       $vertical
     */
    protected function addDivider(ItemInterface $item, $vertical = false)
    {
        $item->addChild(uniqid(), array(
            'attributes' => array(
                'class' => $vertical ? 'divider-vertical' : 'divider',
                'label' => ''
            )
        ));
    }

    private function getTaxonomyRepository()
    {
        return $this->container->get('sylius.repository.taxonomy');
    }
}
