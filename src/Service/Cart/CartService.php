<?php 
namespace App\Service\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService 
{


    private SessionInterface $session;


    public function __construct(SessionInterface $session)
    {
        $this->session = $session;   
    }

    public function add($id)
    {
        $panier = $this->session->get('panier');
        dd($panier);
    }

}