<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\BloggerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default blog categories to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadCategoriesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    private $manager;
    private $manipulator;
    private $catalog;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $this->container->get('sylius_categorizer.manager.category');
        $this->manipulator = $this->container->get('sylius_categorizer.manipulator.category');
        $this->catalog = $this->container->get('sylius_categorizer.registry')->getCatalog('blog');

        $this->createCategory('Symfony2');
        $this->createCategory('Doctrine');
        $this->createCategory('Sylius');
        $this->createCategory('Composer');
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);

        $this->manipulator->create($category);
        $this->setReference('Sandbox.Blogger.Category.'.$name, $category);
    }

    public function getOrder()
    {
        return 2;
    }
}
