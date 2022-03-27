<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/show/{id}', name: 'app_product_show')]
    public function index(int $id, ProduitRepository $pr): Response
    {
        $produit = $pr->find($id);
        if($produit instanceof Produit)
        {
            return $this->render('/product/show.html.twig', [
                'produit' => $produit
            ]);
        } else {
            $this->addFlash("danger", "Le produit recherché n'existe pas.");
            return $this->redirectToRoute('app_home');
        }
    }
}
