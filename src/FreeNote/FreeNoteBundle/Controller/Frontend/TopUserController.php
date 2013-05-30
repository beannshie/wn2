<?php

namespace FreeNote\FreeNoteBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * top user controller.
 */
class TopUserController extends Controller
{
    /**
     * Top user part.
     *
     * @return Response
     */
    public function topUserAction()
    {
        $userAvatarWebPath = null;
        $user = $this->get('security.context')->getToken()->getUser();
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        if($user->getUserProfile())
        {
            $userAvatarWebPath = $user->getUserProfile()->getAvatarWebPath();
        }

        return $this->render('FreeNoteBundle:Frontend/Main:topUser.html.twig', array(
            'avatarPath' => $userAvatarWebPath, 'username' => $username,
        ));
    }
}
