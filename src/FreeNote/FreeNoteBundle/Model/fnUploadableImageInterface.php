<?php

namespace FreeNote\FreeNoteBundle\Model;

interface fnUploadableImageInterface
{
    /**
     * Returns file upload dir (relative to web directory.
     *
     * @return string
     */
    function getImageUploadDir();
}
