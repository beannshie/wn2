<?php

namespace FreeNote\FreeNoteBundle\Model;

use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Comment entity.
 */
class Comment extends BaseComment implements SignedCommentInterface
{
    /**
     * Thread of this comment.
     *
     * @var Thread
     */
    protected $thread;

    /**
     * Author of the comment
     *
     * @var UserInterface
     */
    protected $author;

    /**
     * Sets comment author.
     *
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    /**
     * Gets author.
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Gets author name.
     *
     * @return string
     */
    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }
}
