<?php

namespace App\Controller;

use App\Entity\Crypto;
use App\Entity\User;
use App\Form\AddCryptoType;
use App\Form\AddUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/user/test/{id}", name="user.listTestCryptos") * @return Response
     */
    public function listCryptos($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        //var_dump($user);
        return $this->render('user/listMesCryptos.html.twig', [
            'user' => $user, ]);
    }

    /**
     * Créer une nouvelle crypto.
     * @Route("/user/add", name="user.create") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $user = new User();
        $form = $this->createForm(AddUserType::class, $user); $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('crypto.list');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView(), ]);
    }

    /**
     * @Route("/user/listCyptos/{id}", name="user.listMescryptos")
     * @return Response
     */
    public function listMesCryptos(EntityManagerInterface $em, $id) : Response
    {
        $query = $em->createQuery(
            'SELECT u FROM App:User u WHERE u.id = :id'
        )->setParameter('id', $id);
        $user = $query->getResult();
        //var_dump($user);
        return $this->render('user/listMesCryptos.html.twig', [
            'user' => $user,
        ]);
    }
}
