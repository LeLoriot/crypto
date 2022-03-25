<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginFormAuthenticatorController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * Créer un nouvel utilisateur.
     * @Route("/login/add", name="security.create") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        $user = new User();
        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { $em->persist($user);
            $entityManager = $this->getDoctrine()->getManager();
            //encodage du mot de passe
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $user->getPassword()));
            $entityManager->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/create.html.twig', [
            'form' => $form->createView(), ]);
    }
}
