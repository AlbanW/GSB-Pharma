<?php 
namespace App\Service\Cart;

use App\Entity\Contenance;
use App\Repository\StockRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService 
{


    protected $session;
    protected $stock;


    public function __construct(RequestStack $requestStack, StockRepository $sr)
    {
        $this->session = $requestStack->getSession();   
        $this->stock = $sr;
    }

    public function add($id, $qte)
    {
        $panier = $this->session->get('panier', []);
        if(isset($panier[$id]))
        {
            $panier[$id] = $panier[$id] + $qte;
        } else {
            $panier[$id] = $qte;
        }
        $this->session->set('panier', $panier);
    }

    public function remove($id)
    {
        $panier = $this->session->get('panier', []);
        unset($panier[$id]);
        
        $this->session->set('panier', $panier);
    }

    public function countCart() : int
    {
        return count($this->session->get('panier', []));
    }

    public function getTotal() : float
    {

        $prix = 0.0;
        foreach($this->getCart() as $cart)
        {
            $contenance = ($cart[0][0])->getContenance()->getPrix();
            $qte = $cart[1];
            $prix += $qte * $contenance;
        }

        return $prix;
    }

    public function clearCart()
    {
        $this->session->clear('panier');
    }
    public function getCart()
    {
        $produits = [];
        foreach($this->session->get('panier', []) as $id => $qte)
        {
            $contenance = $this->stock->findBy(array('contenance' => $id));
            $qte = $qte;

            $produits[] = [$contenance, $qte, $id];
        }
        return $produits;
    }
}