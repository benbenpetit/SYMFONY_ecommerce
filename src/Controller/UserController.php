<?php

namespace App\Controller;

use App\Repository\CommandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function index(Security $security, CommandRepository $commandRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'commands' => $commandRepository->findBy(
                ['user' => $security->getUser()]
            )
        ]);
    }
}
