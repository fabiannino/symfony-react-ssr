<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Products;
use App\Entity\ProductSkus;
use \DateTime;


class AdminProductsController extends AbstractController
{
    /**
     * @Route("/admin/products", name="admin_products")
     */
    public function index()
    {

        $products = [
            "link" => 'test',
            "name" => 'test 1 update',
            "description" => 'test 1 description',
            "image" => "image1.jpg",
            "skus" => [
                [
                    "name" => 'test 1 updated again',
                    "image" => "sku1.jpg",
                    "sku" => 'test-1',
                    "status" => 1,
                    "dateAdded" => new DateTime(),
                    "dateAvailable" => new DateTime(),
                    "sort" => 1
                ],
                [
                    "name" => 'test 2',
                    "image" => "sku2.jpg",
                    "sku" => 'test-2',
                    "status" => 1,
                    "dateAdded" => new DateTime(),
                    "dateAvailable" => new DateTime(),
                    "sort" => 2
                ]
            ]
        ];

        $this->execute('create', $products);
        $this->delete(1);

        return $this->render('admin_products/index.html.twig', [
            'controller_name' => 'AdminProductsController',
        ]);
    }
    /*
     * Get Product Info from DB
     */
    private function read($productsId) : ?Products {
        if(is_int($productsId)) {
            return $this->getDoctrine()->getRepository(Products::class)->find($productsId);
        } else {
            return $this->getDoctrine()->getRepository(Products::class)->findByLink($productsId);
        }
    }

    /*
     * Inserts or updates a new product
     */
    private function execute($action, $product) :void
    {

        // Check if Link already exists perform an update
        $prod = $this->read($product['link']);
        if(!$prod) $prod = new Products();
        
        $prod->setLink($product['link']);
        $prod->setName($product['name']);
        $prod->setDescription($product['description']);
        $prod->setImages([$product['image']]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($prod);

        foreach($product['skus'] as $_sku) {
            $sku = $this->executeSku($_sku);
            $sku->setProducts($prod);
            $em->persist($sku);
        }

        $em->flush();
    }

    private function executeSku($sku) :?ProductSkus
    {
        $prodSku = $this->getDoctrine()->getRepository(ProductSkus::class)->findBySku($sku['sku']);
        if(!$prodSku) $prodSku = new ProductSkus();

        $prodSku->setName($sku['name']);
        $prodSku->setImage($sku['image']);
        $prodSku->setSku($sku['sku']);
        $prodSku->setStatus($sku['status']);
        $prodSku->setDateAdded($sku['dateAdded']);
        $prodSku->setDateAvailable($sku['dateAvailable']);
        $prodSku->setSort($sku['sort']);

        return $prodSku;
    }

    /*
     * Detetes a product by Id
     */
    private function delete($productsId) :void
    {
        $product = $this->read($productsId);
        if(!$product) {
            return;
        }
        $skus = $this->getDoctrine()->getRepository(ProductSkus::class)->findBy(["products" => $product->getId()]);
        foreach($skus as $sku) {
            $product->removeProductSkus($sku);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
    }
}
