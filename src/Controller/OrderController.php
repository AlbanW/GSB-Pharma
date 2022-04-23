<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', statusCode: 404, message: 'Page not found')]
class OrderController extends AbstractController
{
    #[Route('/orders', name: 'app_order')]
    public function index(): Response
    {
            return $this->render('order/index.html.twig', [
                'controller_name' => 'OrderController'
            ]);
    }

    #[Route('/order/summary/{id}', name: 'app_order_sum')]
    public function summary($id, CommandeRepository $cr)
    {
        $commande = $cr->find($id);
        return $this->render(
            'order/summary.html.twig', [ 'commande' => $commande ]
        );
    }

    #[Route('/order/validation', name: 'app_order_success')]
    public function validation(): Response
    {
        return $this->render('order/orderSuccess.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
