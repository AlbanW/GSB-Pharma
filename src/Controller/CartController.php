<?php

namespace App\Controller;

use DateTime;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Service\Cart\CartService;
use App\Repository\StockRepository;
use App\Service\Order\OrderService;
use App\Repository\ProduitRepository;
use App\Repository\ContenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function pay(CartService $cart, ContenanceRepository $contenanceR, EntityManagerInterface $em)
    {
        if(isset($_POST['pay']) && $this->getUser() != null)
        {
            $panier = $cart->getCart();
            foreach($panier as $pan)
            {
                $produit = $pan[0][0]->getProduit();
                $stock = $pan[1];
                $stock_id = $pan[0][0]->getId();
                $reste = $contenanceR->find($stock_id)->getStock();

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
                $reste = $contenanceR->find($stock_id)->getStock();


                $commandeProduit = new CommandeProduit();
                $commandeProduit->setContenance($contenanceR->find($stock_id));
                $commandeProduit->setQuantite($stock);
                $commande->addCommandeProduit($commandeProduit);

                
                $contenance = $contenanceR->find($stock_id);
                $contenance->decrementStock($stock);

                $em->persist($contenance);
                $em->flush();
            }

            $commande->setDateCommande(new \DateTime());
            $commande->setStatus(OrderService::STATUS_WAITING);
            $em->persist($commande);
            $em->flush();



            $cart->clearCart();
            return $this->redirectToRoute('app_order_success');
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
