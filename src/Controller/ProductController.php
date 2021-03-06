<?php

namespace App\Controller;

use App\Service\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    #[Route(path: [
        'en' => '/our-products',
        'fr' => '/nos-produits'
    ], name: 'products')]
    public function index(Request $request, Search $search): Response
    {
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->productRepository->findBySearch($search);
        } else {
            $products = $this->productRepository->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    #[Route(path: [
        'en' => '/product/{slug}',
        'fr' => '/produit/{slug}'
    ], name: 'product')]
    public function show($slug, ProductRepository $productRepository): Response
    {
        $product = $this->productRepository->findOneBySlug($slug);
        $bestProducts = $productRepository->findByIsBest(true);
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'bestProducts' => $bestProducts
        ]);
    }
}
