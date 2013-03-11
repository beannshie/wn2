<?php

namespace FreeNote\FreeNoteBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Core extension.
 *
 */
class FreeNoteExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        foreach($config['classes'] as $classname => $classnamedef)
        {
            $container->setParameter('free_note.model.'.$classname.'.class', $classnamedef['model']);
            $container->setParameter('free_note.controller.'.$classname.'.class', $classnamedef['controller']);
            $container->setParameter('free_note.form.type.'.$classname.'.class', $classnamedef['type']);
            $container->setParameter('free_note.repository.'.$classname.'.class', $classnamedef['repository']);
        }
    }
}
