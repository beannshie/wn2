<?php

namespace FreeNote\FreeNoteBundle\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * Article category entity repository.
 */
class ArticleCategoryRepository extends NestedTreeRepository
{
    public function getNodesHierarchyCollection($node = null, $direct = false, array $options = array(), $includeNode = false)
    {
        return $this->getNodesHierarchyQuery($node, $direct, $options, $includeNode)->getResult();
    }
}
