<?php

namespace FreeNote\FreeNoteBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use FreeNote\FreeNoteBundle\Model\fnUploadableImageInterface;

/**
 * UploadableResource controller.
 */
class UploadableResourceController extends ResourceController
{
    /**
     * Get collection (paginated by default) of resources.
     */
    public function indexAction(Request $request)
    {
        $config = $this->getConfiguration();

        $criteria = $config->getCriteria();
        $sorting = $config->getSorting();

//        var_dump($request->getQueryString());exit;
//
//        if($category = $request->get('kategorie', null))
//        {
//            $catalog = $this->container->get('sylius_categorizer.registry')->getCatalog($alias);
//            $category = $this->container->get('sylius_categorizer.manager.category')->findCategoryBy(array('slug' => $slug), $catalog);
//
//            $criteria = array_merge($criteria, $this->request->get('criteria', array()));
//        }

        $pluralName = $config->getPluralResourceName();
        $repository = $this->getRepository();

        if ($config->isPaginated()) {
            $resources = $this
                ->getResourceResolver()
                ->getResource($repository, $config, 'createPaginator', array($criteria, $sorting))
            ;

            $resources
                ->setCurrentPage($request->get('page', 1), true, true)
                ->setMaxPerPage($config->getPaginationMaxPerPage())
            ;
        } else {
            $resources = $this
                ->getResourceResolver()
                ->getResource($repository, $config, 'findBy', array($criteria, $sorting, $config->getLimit()))
            ;
        }

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('index.html'))
            ->setTemplateVar($pluralName)
            ->setData(array(
                'entries' => $resources,
                'resourceName' => $config->getResourceName()
            ))
        ;

        return $this->handleView($view);
    }

    public function persistAndFlush($resource)
    {
        $manager = $this->getManager();
        $manager->persist($resource);

        //for doctrine uploadable extension
        if($resource->getImage())
        {
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

            // change saved to database path to image
            if($resource instanceof fnUploadableImageInterface)
            {
                $resource->setImageAbsolutePath($this->container->getParameter('fn_web_dir').DIRECTORY_SEPARATOR.$resource->getImageUploadDir());
            }

            // Here, "getImage" returns the "UploadedFile" instance that the form bound in your $Image property
            $uploadableManager->markEntityToUpload($resource, $resource->getImage());
        }

        $manager->flush();
    }
}
