<?php

namespace App\Controller;

use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ProduitRepository                        $produitRepository;



    public function __construct(ProduitRepository $pr)
    {
        $this->produitRepository = $pr;
    }

    #[Route('/', name: 'app_home')]
    public function index(MarqueRepository $marque): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $this->produitRepository->findAll(),
            'marques' => $marque->findAll()
        ]);
    }
}
