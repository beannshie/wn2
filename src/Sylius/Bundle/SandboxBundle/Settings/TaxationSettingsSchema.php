<?php

namespace Sylius\Bundle\SandboxBundle\Settings;

use Doctrine\Common\Persistence\ObjectRepository;
use Wn\WnBundle\Transformer\wnZoneToIdentifierTransformer;
use Sylius\Bundle\AddressingBundle\Form\DataTransformer\ZoneToIdentifierTransformer;
use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;

/**
 * Taxation settings schema.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class TaxationSettingsSchema implements SchemaInterface
{
    private $zoneRepository;

    public function __construct(ObjectRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('defaultTaxZone', 'sylius_zone_choice', array(
                'label' => 'Default tax zone'
            ))
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder->setDefaults(array(
            'defaultTaxZone' => '',
        ));

        $builder->setTransformer('defaultTaxZone', new wnZoneToIdentifierTransformer($this->zoneRepository, 'id'));
    }
}
