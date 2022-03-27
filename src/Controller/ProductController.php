<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\CartType;
use App\Repository\CategorieRepository;
use App\Repository\ContenanceRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/show/{id}', name: 'app_product_show')]
    public function index(int $id, ProduitRepository $pr, Request $request): Response
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

    #[Route('/category/{id}', name: 'app_product_category')]
    public function category(int $id = -1, CategorieRepository $cr, ProduitRepository $pr): Response
    {
        $produits = $pr->findAll();
        if($id != -1 AND $cr->find($id))
        {
            $produits = $pr->findBy(array('category' => $id));
        } 
        
        return $this->render("/product/category.html.twig", [
            "products" => $produits,
            "categories" => $cr->findAll()
        ]);
    }
    

    #[Route('/ajax', methods: ['POST'], name:'app_ajax')]
    public function ajax(Request $request, ContenanceRepository $cr) :JsonResponse
    {
        $id = $request->request->get('id');
        if($cr->find($id))
        {
            $crr  = $cr->find($id)->getPrix();
        return new JsonResponse(array(
            'status' => 'Prix',
            'message' => "$crr"),
        200);
        }
    }
}
