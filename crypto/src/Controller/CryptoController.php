<?php

namespace App\Controller;

use App\Entity\Crypto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * Lister toutes les cryptos.
     * @Route("lesCryptos/detail/{id}", name="crypto.show") * @return Response
     */
    public function detail($id) : Response
    {
        $crypto = $this->getDoctrine()->getRepository(Crypto::class)->find($id);
        return $this->render('crypto/show.html.twig', [
            'crypto' => $crypto, ]);
    }

}

