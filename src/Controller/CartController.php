<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\CommandRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);

        if ($productRepository->find($id) == null) {
            return new Response('Cannot find item with id ' . $id);
        }

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return new Response('Article added to cart');
    }

    #[Route('/cart/subtract/{id}', name: 'cart_subtract')]
    public function subtract($id, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);

        if ($productRepository->find($id) == null) {
            return new Response('Cannot find item with id ' . $id);
        }

        if (!empty($cart[$id])) {
            if ($cart[$id] === 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]--;
            }
        }

        $session->set('cart', $cart);

        return new Response('Article subtracted to cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->render('cart/index.html.twig');
    }

    #[Route('/cart/order', name: 'cart_order')]
    public function order(Security $security, ProductRepository $productRepository, SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $user = $security->getUser();
        $cart = $session->get('cart', []);

        if ($cart === []) {
            return $this->redirectToRoute('cart');
        }

        if (!$user) {
            $session->set('redirection', 'cart');
            return $this->redirectToRoute('login', ['_target_path' => '/cart']);
        }

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        if ($user === null) {
            return $this->redirectToRoute('cart');
        }

        $entityManager = $doctrine->getManager();
        
        $command = new Command();
        $command->setDate(new \DateTime());
        $command->setPrice($total);
        $command->setUser($user);

        foreach ($cart as $id => $quantity) {
            $command->addProduct($productRepository->find($id));
        }

        $entityManager->persist($command);
        $entityManager->flush();

        $session->set('cart', []);

        return $this->render('cart/order.html.twig');
    }
}
