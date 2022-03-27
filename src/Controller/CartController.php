<?php

namespace App\Controller;

use App\Repository\ContenanceRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add', methods: ["POST"], name: 'app_cart_add')]
    public function add(ContenanceRepository $cr, CartService $cs): Response
    {
        $contenance = ($_POST['contenance']);
        $quantity = ($_POST['quantity']); 
        if(is_numeric($contenance) && is_numeric($quantity))
        {       
            $find = $cr->find($contenance);
            if($find)
            {
                $cs->add([$contenance, $quantity]);
                $this->addFlash('success', 'L\'article à bien été ajouté a votre panier.');
            }
        }
        return $this->redirectToRoute('app_home');

    }
}
