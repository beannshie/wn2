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


    /**
     * Change image title and alt if not set and image is uploaded
     */
    function generateTitleAlt();
}
