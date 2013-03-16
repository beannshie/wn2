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
    public function persistAndFlush($resource)
    {
        $manager = $this->getManager();
        $manager->persist($resource);

        //for doctrine uploadable extension
        if($resource->getMainImage())
        {
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

            // change saved to database path to image
            if($resource instanceof fnUploadableImageInterface)
            {
                $resource->setMainImageAbsolutePath($this->container->getParameter('fn_web_dir').DIRECTORY_SEPARATOR.$resource->getImageUploadDir());
            }

            // Here, "getMainImage" returns the "UploadedFile" instance that the form bound in your $mainImage property
            $uploadableManager->markEntityToUpload($resource, $resource->getMainImage());
        }

        $manager->flush();
    }
}
