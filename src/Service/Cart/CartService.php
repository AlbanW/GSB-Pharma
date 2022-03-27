<?php 
namespace App\Service\Cart;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService 
{


    protected $session;


    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();   
    }

    public function add($data)
    {
        $panier = $this->session->get('panier', []);
        $panier[] = $data;
        $this->session->set('panier', $panier);
        dd($this->session);
    }

    public function countCart() : int
    {
        return count($this->session->get('panier', []));
    }
}