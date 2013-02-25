<?php

namespace FreeNote\FreeNoteBundle\Settings;

use Doctrine\Common\Persistence\ObjectRepository;
use FreeNote\FreeNoteBundle\Transformer\wnZoneToIdentifierTransformer;
use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;

/**
 * Taxation settings schema.
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
            'defaultTaxZone' => 'id',
        ));

        $builder->setTransformer('defaultTaxZone', new wnZoneToIdentifierTransformer($this->zoneRepository, 'id'));
    }
}
