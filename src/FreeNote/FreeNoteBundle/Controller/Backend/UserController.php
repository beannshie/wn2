<?php

namespace FreeNote\FreeNoteBundle\Controller\Backend;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FreeNote\FreeNoteBundle\Model\fnUserParameters;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/**
 * User controller.
 *
 */
class UserController extends BaseController
{
    public function registerAction($who = null)
    {
        $formType = $this->container->get('free_note.user.registration.form.type');
        $formType->setRole(fnUserParameters::getRoleBySlug($who));

        $form = $this->container->get('fos_user.registration.form');

        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $formHandler->addUserRole($who);
        $process = $formHandler->process(false);
        if ($process) {
            $route = 'free_note_backend_user_registration_confirmed';
            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            return $response;
        }

        return $this->container->get('templating')->renderResponse('FreeNoteBundle:Backend/User:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(), 'who' => $who
        ));
    }

    public function confirmedAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FreeNoteBundle:Backend/User:confirmed.html.'.$this->getEngine(), array(
            'user' => $user,
        ));
    }
}
