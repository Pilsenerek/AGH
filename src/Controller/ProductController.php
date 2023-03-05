<?php

namespace App\Controller;

use App\Entity\Product;
use App\Message\AddProduct;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api')]
class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_index', methods: 'GET')]
    public function index(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse($serializer->serialize($productRepository->findAll(), 'json'), 200, [], true);
    }

    #[Route('/product/{id}', name: 'product_detail', methods: 'GET')]
    public function detail($id, ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse($serializer->serialize($productRepository->findOneBy(['id' => $id]), 'json'), 200, [], true);
    }

    #[Route('/product', name: 'product_create', methods: 'POST')]
    public function create(Request $request, EntityManagerInterface $em, MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(new AddProduct($request->get('name')));

        //$product = new Product();
        //$product->setName($request->get('name'));
        //$em->persist($product);
        //$em->flush();

        return $this->json([], 202);
    }
}
