<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Menu builder.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Builder extends ContainerAware
{
    /**
     * Builds frontend main menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
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

        $menu->addChild('Strona główna', array('route' => 'sylius_sandbox_core_frontend'));

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $child = $menu->addChild('Oferta', $childOptions);
        $child->addChild('Produkty', array('route' => 'sylius_assortment_product_list'));

        $child = $menu->addChild('Aktualności', $childOptions);
        $child->addChild('Wpisy', array('route' => 'sylius_blogger_post_list'));

        $child = $menu->addChild('Koszyk', array('route' => 'sylius_cart_show'));

        return $menu;
    }

    /**
     * Builds frontend side menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
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

        $categoryManager = $this->container->get('sylius_categorizer.manager.category');

        $assortmentCategories = $categoryManager->findCategories('assortment');
        $child = $menu->addChild('Kategorie produktów', $childOptions);

        foreach ($assortmentCategories as $category) {
            $child->addChild($category['name'], array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'assortment',
                    'slug'  => $category['slug']
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }

        $blogCategories = $categoryManager->findCategories('blog');
        $child = $menu->addChild('Kategorie aktualności', $childOptions);

        foreach ($blogCategories as $category) {
            $child->addChild($category->getName(), array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'blog',
                    'slug'  => $category->getSlug()
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
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
            $child->addChild('Panel admnistratora', array(
                'route' => 'sylius_sandbox_core_backend',
                'labelAttributes' => array('icon' => 'icon-lock')
            ));
        }

        return $menu;
    }

    /**
     * Builds backend main menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
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

        $menu->addChild('Panel administratora', array('route' => 'sylius_sandbox_core_backend'));

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addBlogMenu($menu, $childOptions);
        $this->addAddressingMenu($menu, $childOptions);

        $this->addDivider($menu, true);

        $menu->addChild('Przejdź do <strong>strony głównej</strong>', array('route' => 'sylius_sandbox_core_frontend'));

        return $menu;
    }

    /**
     * Builds backend side menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
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

        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addBlogMenu($menu, $childOptions);
        $this->addAddressingMenu($menu, $childOptions);

        $child = $menu->addChild('Administracja', $childOptions);
        $child->addChild('Wyloguj', array(
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

        // Categories.
        $child->addChild('Utwórz kategorię', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'assortment'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'assortment'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Products.
        $child->addChild('Dodaj produkt', array(
            'route'           => 'sylius_assortment_backend_product_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista produktów', array(
            'route'           => 'sylius_assortment_backend_product_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Option types.
        $child->addChild('Dodaj opcję', array(
            'route'           => 'sylius_assortment_backend_option_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista opcji', array(
            'route'           => 'sylius_assortment_backend_option_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Properties.
        $child->addChild('Dodaj właściwość', array(
            'route'           => 'sylius_assortment_backend_property_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista właściwości', array(
            'route'           => 'sylius_assortment_backend_property_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Prototypes.
        $child->addChild('Dodaj prototyp', array(
            'route'           => 'sylius_assortment_backend_prototype_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista prototypów', array(
            'route'           => 'sylius_assortment_backend_prototype_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
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
            'route'           => 'sylius_sales_backend_order_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
        $child->addChild('Dodaj zamówienie', array(
            'route'           => 'sylius_sales_backend_order_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));

        $this->addDivider($child);

        $child->addChild('Zarządzaj statusami', array(
            'route'           => 'sylius_sales_backend_status_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds blog menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addBlogMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Aktualności', $childOptions);

        $child->addChild('Dodaj kategorię', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'blog'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista kategorii', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'blog'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        $child->addChild('Dodaj wpis', array(
            'route' => 'sylius_blogger_backend_post_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista wpisów', array(
            'route'           => 'sylius_blogger_backend_post_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds addressing menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addAddressingMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Książka adresowa', $childOptions);

        $child->addChild('Dodaj adres', array(
            'route' => 'sylius_addressing_backend_address_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('Lista adresów', array(
            'route' => 'sylius_addressing_backend_address_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
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
                'class' => $vertical ? 'divider-vertical' : 'divider'
            )
        ));
    }
}
