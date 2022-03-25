<?php

namespace App\Controller;

use App\Entity\Crypto;

use App\Form\AddCryptoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM;



class CryptoController extends AbstractController
{
    /**
     * @Route("/crypto", name="app_crypto")
     */
    public function index(): Response
    {
        return $this->render('crypto/index.html.twig', [
            'controller_name' => 'CryptoController',
        ]);
    }

    /**
     * Lister toutes les cryptos.
     * @Route("/lesCryptos", name="crypto.list") * @return Response
     */
    public function list() : Response
    {
        $cryptos = $this->getDoctrine()->getRepository(Crypto::class)->findAll();
        return $this->render('crypto/list.html.twig', [
            'cryptos' => $cryptos, ]);
    }

    /**
     * Lister les détails d'une crypto.
     * @Route("lesCryptos/detail/{idC}", name="crypto.show") * @return Response
     */
    public function detail($idC) : Response
    {
        $crypto = $this->getDoctrine()->getRepository(Crypto::class)->find($idC);
        return $this->render('crypto/show.html.twig', [
            'crypto' => $crypto, ]);
    }

    /**
     * Créer une nouvelle crypto.
     * @Route("/lesCryptos/add", name="crypto.create") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $crypto = new Crypto();
        $form = $this->createForm(AddCryptoType::class, $crypto); $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { $em->persist($crypto);
            $em->flush();
            return $this->redirectToRoute('crypto.list');
        }
        return $this->render('crypto/create.html.twig', [
            'form' => $form->createView(), ]);
    }

    /**
     * Éditer une crypto.
     * @Route("lesCryptos/{id}/edit", name="crypto.edit") * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Crypto $crypto, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(AddCryptoType::class, $crypto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('crypto.list');
        }
        return $this->render('crypto/edit.html.twig', [
            'form' => $form->createView(), ]);
    }

    /**
     * Supprimer une crypto.
     * @Route("lesCryptos/{id}/delete", name="crypto.delete") * @param Request $request
     * @param Crypto $crypto
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, Crypto $crypto, EntityManagerInterface $em) : Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('crypto.delete', ['id' => $crypto->getId()])) ->getForm();
        $form->handleRequest($request);
        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            return $this->render('crypto/delete.html.twig', [ 'crypto' => $crypto,
                'form' => $form->createView(),
            ]); }
        $em = $this->getDoctrine()->getManager();
        $em->remove($crypto);
        $em->flush();
        return $this->redirectToRoute('crypto.list');
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }

}

