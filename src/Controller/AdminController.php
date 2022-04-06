<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN', statusCode: 404, message: 'Page not found')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/products', name: 'app_admin_show_products')]
    public function showProduct(ProduitRepository $pr)
    {
        $products = $pr->findAll();
        return $this->render('admin/showProduct.html.twig', [
            'produits' => $products
        ]);
    }

    #[Route('/admin/products/create', name: 'app_admin_create_product')]
    public function createProduct(CategorieRepository $cr)
    {
        return $this->render('admin/createProduct.html.twig', [
            "category" => $cr->findAll()
        ]);
    }

}
