<?php

namespace App\Controller;

use App\Entity\Crypto;
use App\Entity\User;
use App\Form\AddCryptoType;
use App\Form\AddUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
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
     * @Route("/user/listMesCryptos/", name="user.listMesCryptos") * @return Response
     */
    public function listMesCryptos(): Response
    {
        //Recupere le user actuellement connecté
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('email' => $this->getUser()->getUsername()));
        //var_dump($user);
        return $this->render('user/listMesCryptos.html.twig', [
            'monUser' => $user,]);
    }

    /**
     * @Route("/user/addFavorisCryptos/{idC}", name="user.addFavorisCrypto") * @return Response
     * @param EntityManagerInterface $em
     * @param Crypto $idC
     * @return Response
     */
    public function addFavorisCrypto($idC, EntityManagerInterface $em): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('email' => $this->getUser()->getUsername()));
        //dd($user);
        $crypto = $this->getDoctrine()->getRepository(Crypto::class)->findOneBy(array('id' => $idC));
        //dd($crypto[0]);
        //$crypto->addUser($user[0]);
        $user->addMesCrypto($crypto);
        $em->flush();
        //var_dump($user);
        //dd($user);
        return $this->render('user/listMesCryptos.html.twig', [
            'monUser' => $user,]);
    }

    /**
     * Créer une nouvelle crypto.
     * @Route("/user/add", name="user.create") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('crypto.list');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),]);
    }

    /**
     * ajouter une crypto en favoris
     * @Route("/user/deleteFavorisCrypto/{idC}", name="user.deleteFavorisCrypto") * @return Response
     * @param EntityManagerInterface $em
     * @param Crypto $idC
     * @return Response
     */
    public function deleteFavorisCrypto($idC, EntityManagerInterface $em): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('email' => $this->getUser()->getUsername()));
        //dd($user);
        $crypto = $this->getDoctrine()->getRepository(Crypto::class)->findOneBy(array('id' => $idC));
        //dd($crypto[0]);
        //$crypto->addUser($user[0]);
        $user->removeMesCrypto($crypto);
        $em->flush();
        //var_dump($user);
        //dd($user);
        return $this->render('user/listMesCryptos.html.twig', [
            'monUser' => $user,]);
    }

    /**
     * Lister les utilisateurs.
     * @Route("/lesUsers", name="user.list") * @return Response
     */
    public function list() : Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/list.html.twig', [
            'users' => $users, ]);
    }

    /**
     * Éditer un user.
     * @Route("lesUsers/{id}/edit", name="user.edit") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, User $user, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('user.list');
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(), ]);
    }

    /**
     * Supprimer un user.
     * @Route("lesUsers/{id}/delete", name="user.delete") * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, User $user, EntityManagerInterface $em) : Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('user.delete', ['id' => $user->getId()])) ->getForm();
        $form->handleRequest($request);
        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            return $this->render('user/delete.html.twig', [ 'user' => $user,
                'form' => $form->createView(),
            ]); }
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user.list');
    }




}
