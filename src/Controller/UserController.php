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
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('user/commands.html.twig', [
            'commands' => $commandRepository->findBy(
                ['user' => $security->getUser()]
            )
        ]);
    }

    #[Route('/user/profile/command/{id}', name: 'user_profile_command')]
    public function command($id, Security $security, CommandRepository $commandRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $command = $commandRepository->find($id);

        if (!$command) {
            return $this->redirectToRoute('user_profile');
        }

        if ($command->getUser() != $this->getUser()) {
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/command.html.twig', [
            'command' => $command,
            'items' => $command->getProduct()
        ]);
    }
}
