<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product')]
    public function index($id, ProductRepository $productRepository, SessionInterface $session): Response
    {
        $product = $productRepository->find($id);

        return $this->render('product/index.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product')]
    public function noId(): Response
    {
        return $this->redirectToRoute('home');
    }
}
