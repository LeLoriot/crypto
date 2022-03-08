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
     * @Route("/lesCryptos/", name="crypto.list") * @return Response
     */
    public function list() : Response
    {
        $cryptos = $this->getDoctrine()->getRepository(Crypto::class)->findAll();
        return $this->render('crypto/list.html.twig', [
            'cryptos' => $cryptos, ]);
    }

    /**
     * Lister les détails d'une crypto.
     * @Route("lesCryptos/detail/{id}", name="crypto.show") * @return Response
     */
    public function detail($id) : Response
    {
        $crypto = $this->getDoctrine()->getRepository(Crypto::class)->find($id);
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


}

