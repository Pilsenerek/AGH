<?php

namespace App\MessageHandler;

use App\Entity\Product;
use App\Message\AddProduct;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;

#[AsMessageHandler]
class AddProductHandler
{
    public function __construct(private EntityManagerInterface $em) {}

    public function __invoke(AddProduct $message)
    {
        $product = new Product();
        $product->setName($message->getName());
        $this->em->persist($product);
        $this->em->flush();
    }
}
