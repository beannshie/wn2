<?php

namespace FreeNote\FreeNoteBundle\Controller\Backend;

use Sylius\Bundle\CategorizerBundle\Controller\Backend\CategoryController;

class fnCategoryController extends CategoryController
{
    public function listAction($alias)
    {
        $catalog = $this->container->get('sylius_categorizer.registry')->getCatalog($alias);
        $categories = $this->container->get('sylius_categorizer.manager.category')->findChildrenHierarchyCollection($catalog);

        return $this->container->get('templating')->renderResponse(sprintf($catalog->getOption('templates.backend'), 'list'), array(
            'catalog'    => $catalog,
            'categories' => $categories
        ));
    }
}
