<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/listMesCryptos/{id}", name="app_user")
     */
    public function listMesCryptos($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('crypto/listMesCryptos.html.twig', [
            'user' => $user, ]);
    }
}
