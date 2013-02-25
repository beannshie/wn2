<?php

namespace FreeNote\FreeNoteBundle\Transformer;

use Sylius\Bundle\AddressingBundle\Form\DataTransformer\ZoneToIdentifierTransformer;
use Sylius\Bundle\SettingsBundle\Transformer\ParameterTransformerInterface;

/**
 * Zone to id transformer.
 */
class wnZoneToIdentifierTransformer extends ZoneToIdentifierTransformer implements ParameterTransformerInterface
{
}
