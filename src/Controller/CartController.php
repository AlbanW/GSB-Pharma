<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Repository\ContenanceRepository;
use App\Repository\StockRepository;
use App\Service\Cart\CartService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
                $cs->add($contenance, $quantity);
                $this->addFlash('success', 'L\'article à bien été ajouté a votre panier.');
            }
        }
        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/pay', methods: ["POST"], name: 'app_cart_pay')]
    public function pay(CartService $cart, StockRepository $stockR, EntityManagerInterface $em)
    {
        if(isset($_POST['pay']) && $this->getUser() != null)
        {
            $panier = $cart->getCart();
            foreach($panier as $pan)
            {
                $contenance = $pan[0][0]->getContenance();
                $produit = $pan[0][0]->getProduit();
                $stock = $pan[1];
                $stock_id = $pan[0][0]->getId();
                $reste = $stockR->find($stock_id)->getStock();

                if($stock > $reste)
                {
                    $this->addFlash('danger', 'Le produit '.$produit->getNom().' n\'est plus en stock.');
                    return $this->redirectToRoute('app_cart');
                }
            }
            

            $commande = new Commande();
            $commande->setClient($this->getUser());

            foreach($panier as $pan)
            {
                $produit = $pan[0][0]->getProduit();
                $stock = $pan[1];
                $stock_id = $pan[0][0]->getId();
                $reste = $stockR->find($stock_id)->getStock();
                
                $commandeProduit = new CommandeProduit();
                $commandeProduit->setProduit($stockR->find($stock_id));
                $commandeProduit->setQuantite($stock);
                $commande->addCommandeProduit($commandeProduit);
            }

            $commande->setDateCommande(new \DateTime());
            $em->persist($commande);
            $em->flush();

            $cart->clearCart();
            $this->addFlash('success', 'Commande succès');

            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/cart/remove/{id}', methods: ["GET"], name: 'app_cart_remove')]
    public function remove(int $id, CartService $cs): Response
    {
        $cs->remove($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart', methods: ["GET"], name: 'app_cart')]
    public function show(): Response
    {
        return $this->render(
            'cart/show.html.twig'
        );
    }
}
