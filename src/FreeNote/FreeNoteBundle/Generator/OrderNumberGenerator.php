<?php

namespace FreeNote\FreeNoteBundle\Generator;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\SalesBundle\Generator\OrderNumberGeneratorInterface;

class OrderNumberGenerator implements OrderNumberGeneratorInterface
{
    /**
     * Order repository.
     *
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Order number max length.
     *
     * @var integer
     */
    protected $numberLength;

    /**
     * Constructor.
     *
     * @param ObjectRepository $repository
     */
    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@interitdoc}
     */
    public function generate(OrderInterface $order)
    {
        $order->setNumber($this->getOrderPrefix().($order->getUser()?$order->getUser()->getId():'nn').$this->getOrderPostfix());
    }

    /**
     * Get last order number.
     *
     * @return string
     */
    protected function getOrderPrefix()
    {
        return (str_replace('.', '/', microtime(true))).'/';
    }

    /**
     * Get order postfix.
     *
     * @return string
     */
    protected function getOrderPostfix()
    {
        return '';
    }
}
