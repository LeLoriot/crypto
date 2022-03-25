<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Crypto;
use App\Entity\User;
use App\Form\AddCommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="app_commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    /**
     * Créer un nouveau commentaire.
     * @Route("/newCom/{idC}" , name="commentaire.index") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em, $idC) : Response
    {
        $com = new Commentaire();
        $com->setDate(new \DateTime('now'));
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('email' => $this->getUser()->getUsername()));
        $crypto = $this->getDoctrine()->getRepository(Crypto::class)->find($idC);


        $form = $this->createForm(AddCommentaireType::class, $com);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { $em->persist($com);
            $user->addCommentaire($com);
            $crypto->addCommentaire($com);

            $em->flush();
            return $this->redirectToRoute('crypto.list');
        }
        return $this->render('commentaire/index.html.twig', [
            'form' => $form->createView(), ]);
    }

    /**
     * Supprimer un commentaire.
     * @Route("commentaire/{id}/delete", name="commentaire.delete") * @param Request $request
     * @param Commentaire $com
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, Commentaire $com, EntityManagerInterface $em) : Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaire.delete', ['id' => $com->getId()])) ->getForm();
        $form->handleRequest($request);
        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            return $this->render('commentaire/delete.html.twig', [ 'com' => $com,
                'form' => $form->createView(),
            ]); }
        $em = $this->getDoctrine()->getManager();
        $em->remove($com);
        $em->flush();
        return $this->redirectToRoute('crypto.list');
    }
}
