<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default assortment product properties to play with Sylius sandbox.
 */
class LoadPropertiesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->createProperty('T-Shirt brand', 'Brand', 'Property.T-Shirt.Brand');
        $this->createProperty('T-Shirt collection', 'Collection', 'Property.T-Shirt.Collection');
        $this->createProperty('T-Shirt material', 'Made of', 'Property.T-Shirt.Made-of');

        $this->createProperty('Sticker print resolution', 'Print resolution', 'Property.Sticker.Resolution');
        $this->createProperty('Sticker paper', 'Paper', 'Property.Sticker.Paper');

        $this->createProperty('Mug material', 'Material', 'Property.Mug.Material');

        $this->createProperty('Book author', 'Author', 'Property.Book.Author');
        $this->createProperty('Book ISBN', 'ISBN', 'Property.Book.ISBN');
        $this->createProperty('Book pages', 'Number of pages', 'Property.Book.Pages');

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Create property.
     *
     * @param string $name
     * @param string $presentation
     * @param string $reference
     */
    private function createProperty($name, $presentation, $reference)
    {
        $manager = $this->getPropertyManager();
        $repository = $this->getPropertyRepository();

        $property = $repository->createNew();
        $property->setName($name);
        $property->setPresentation($presentation);

        $manager->persist($property);
        $this->setReference($reference, $property);
    }

    private function getPropertyManager()
    {
        return $this->get('sylius.manager.property');
    }

    private function getPropertyRepository()
    {
        return $this->get('sylius.repository.property');
    }
}
