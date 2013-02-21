<?php

namespace Wn\WnBundle\Transformer;

use Sylius\Bundle\AddressingBundle\Form\DataTransformer\ZoneToIdentifierTransformer;
use Sylius\Bundle\SettingsBundle\Transformer\ParameterTransformerInterface;

/**
 * Zone to id transformer.
 */
class wnZoneToIdentifierTransformer extends ZoneToIdentifierTransformer implements ParameterTransformerInterface
{
//    /**
//     * Zone repository.
//     *
//     * @var ObjectRepository
//     */
//    private $zoneRepository;
//
//    /**
//     * Identifier.
//     *
//     * @var string
//     */
//    private $identifier;
//
//    /**
//     * Constructor.
//     *
//     * @param ObjectRepository $zoneRepository
//     * @param string           $identifier
//     */
//    public function __construct(ObjectRepository $zoneRepository, $identifier)
//    {
//        $this->zoneRepository = $zoneRepository;
//        $this->identifier = $identifier;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function transform($zone)
//    {
//        if (null === $zone) {
//            return '';
//        }
//
//        if (!$zone instanceof ZoneInterface) {
//            throw new UnexpectedTypeException($zone, 'Sylius\Bundle\AddressingBundle\Model\ZoneInterface');
//        }
//
//        $accessor = PropertyAccess::getPropertyAccessor();
//
//        return $accessor->getValue($zone, $this->identifier);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function reverseTransform($value)
//    {
//        if (!$value) {
//            return null;
//        }
//
//        return $this->zoneRepository->findOneBy(array($this->identifier => $value));
//    }
}
