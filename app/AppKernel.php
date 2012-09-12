<?php

use Symfony\Component\ClassLoader\DebugUniversalClassLoader;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle($this),
            new \FOS\RestBundle\FOSRestBundle(),
            new \FOS\UserBundle\FOSUserBundle(),
            new \FOS\CommentBundle\FOSCommentBundle(),
            new \Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new \Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),

            /*
            * Sylius bundles.
            */
            new \Sylius\Bundle\AddressingBundle\SyliusAddressingBundle(),
            new \Sylius\Bundle\AssortmentBundle\SyliusAssortmentBundle(),
            new \Sylius\Bundle\BloggerBundle\SyliusBloggerBundle(),
            new \Sylius\Bundle\CartBundle\SyliusCartBundle(),
            new \Sylius\Bundle\CategorizerBundle\SyliusCategorizerBundle(),
            new \Sylius\Bundle\FlowBundle\SyliusFlowBundle(),
            new \Sylius\Bundle\InventoryBundle\SyliusInventoryBundle(),
            new \Sylius\Bundle\SalesBundle\SyliusSalesBundle(),

            /*
             * Sandbox specific bundles.
             */
            new \Sylius\Sandbox\Bundle\AddressingBundle\SandboxAddressingBundle(),
            new \Sylius\Sandbox\Bundle\AssortmentBundle\SandboxAssortmentBundle(),
            new \Sylius\Sandbox\Bundle\BloggerBundle\SandboxBloggerBundle(),
            new \Sylius\Sandbox\Bundle\CartBundle\SandboxCartBundle(),
            new \Sylius\Sandbox\Bundle\CoreBundle\SandboxCoreBundle(),
            new \Sylius\Sandbox\Bundle\SalesBundle\SandboxSalesBundle(),
            new \Sylius\Sandbox\Bundle\UserBundle\SandboxUserBundle(),
            new \Sylius\Sandbox\Bundle\CommentBundle\SandboxCommentBundle(),

            /*
            * Wn bundles.
            */
            new Wn\UserBundle\WnUserBundle(),
            new Wn\CoreBundle\WnCoreBundle(),
            new Wn\AssortmentBundle\WnAssortmentBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
//            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerRootDir()
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->debug) {
            ini_set('display_errors', 1);
            error_reporting(-1);

            DebugUniversalClassLoader::enable();
            ErrorHandler::register();
            if ('cli' !== php_sapi_name()) {
                ExceptionHandler::register();
            }
        } else {
            ini_set('display_errors', 0);
        }

        ini_set('date.timezone', 'UTC');
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
