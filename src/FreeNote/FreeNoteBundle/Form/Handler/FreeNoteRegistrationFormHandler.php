<?php

namespace FreeNote\FreeNoteBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler;
use FreeNote\FreeNoteBundle\Model\fnUserParameters;
use Symfony\Component\Form\FormInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;

class FreeNoteRegistrationFormHandler extends RegistrationFormHandler
{
    protected $userProfileManager;
    protected $userRoles = array();

    public function __construct(FormInterface $form, Request $request, UserManagerInterface $userManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, $userProfileManager)
    {
        parent::__construct($form, $request, $userManager, $mailer, $tokenGenerator);
        $this->userProfileManager = $userProfileManager;
    }

    /**
     * @param boolean $confirmation
     */
    protected function onSuccess(UserInterface $user, $confirmation)
    {
        if ($confirmation) {
            $user->setEnabled(false);
            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($this->tokenGenerator->generateToken());
            }

            $this->mailer->sendConfirmationEmailMessage($user);
        } else {
            $user->setEnabled(true);
        }

        $user = $this->processRoles($user);

        $this->userManager->updateUser($user);

        $user->getUserProfile()->setUser($user);
        $this->userProfileManager->persist($user->getUserProfile());
        $this->userProfileManager->flush();
    }

    protected function processRoles($user)
    {
        foreach($this->userRoles as $role)
        {
            $user->addRole($role);
        }
        return $user;
    }

    public function setUserRoles($userRoleSlugs)
    {
        foreach($userRoleSlugs as $slug)
        {
            $this->userRoles[$slug] = fnUserParameters::getRoleBySlug($slug);
        }
    }

    public function addUserRole($roleSlug)
    {
        $this->userRoles[$roleSlug] = fnUserParameters::getRoleBySlug($roleSlug);
    }
}
