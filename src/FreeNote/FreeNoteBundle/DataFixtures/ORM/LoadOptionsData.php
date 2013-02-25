<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default assortment product options to play with sandbox.
 */
class LoadOptionsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->optionValueClass = $this->container->getParameter('sylius.model.option_value.class');

        // T-Shirt size option.
        $this->createOption(
            'T-Shirt size',
            'Size',
            array(
                'S',
                'M',
                'L',
                'XL',
                'XXL'
            ),
            'Option.T-Shirt.Size'
        );

        // T-Shirt color option.
        $this->createOption(
            'T-Shirt color',
            'Color',
            array(
                'Red',
                'Blue',
                'Green'
            ),
            'Option.T-Shirt.Color'
        );

        // Sticker size option.
        $this->createOption(
            'Sticker size',
            'Size',
            array(
                '3"',
                '5"',
                '7"'
            ),
            'Option.Sticker.Size'
        );

        // Mug type option.
        $this->createOption(
            'Mug type',
            'Type',
            array(
                'Medium mug',
                'Double mug',
                'MONSTER mug'
            ),
            'Option.Mug.Type'
        );

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * Create an option.
     *
     * @param string $name
     * @param string $presentation
     * @param array  $values
     * @param string $reference
     */
    private function createOption($name, $presentation, array $values, $reference)
    {
        $option = $this
            ->getOptionRepository()
            ->createNew()
        ;

        $option->setName($name);
        $option->setPresentation($presentation);

        foreach ($values as $text) {
            $value = new $this->optionValueClass;
            $value->setValue($text);

            $option->addValue($value);
        }

        $this
            ->getOptionManager()
            ->persist($option)
        ;

        $this->setReference($reference, $option);
    }

    private function getOptionManager()
    {
        return $this->get('sylius.manager.option');
    }

    private function getOptionRepository()
    {
        return $this->get('sylius.repository.option');
    }
}
