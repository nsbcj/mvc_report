<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/product/create", name="product_create", methods="GET")
     */
    public function createProduct(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard_num_' . rand(1, 9));
        $product->setValue(rand(100, 999));

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/product/show", name="product_show_all", methods="GET")
     */
    public function showAllProduct(
        ProductRepository $productRepository
    ): Response {
        $products = $productRepository
            ->findAll();

        return $this->json($products);
    }

    /**
     * @Route("/product/show/{id}", name="product_by_id", methods="GET")
     */
    public function showProductById(
        ProductRepository $productRepository,
        int $id
    ): Response {
        $product = $productRepository
            ->find($id);

        return $this->json($product);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete_by_id", methods="GET")
     */
    public function deleteProductById(
        ProductRepository $productRepository,
        int $id
    ): Response {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $productRepository->remove($product, true);

        return $this->redirectToRoute('product_show_all');
    }

    /**
     * @Route("/product/update/{id}/{value}", name="product_update", methods="GET")
     */
    public function updateProduct(
        ProductRepository $productRepository,
        int $id,
        int $value
    ): Response {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setValue($value);
        $productRepository->save($product, true);

        return $this->redirectToRoute('product_show_all');
    }
}
