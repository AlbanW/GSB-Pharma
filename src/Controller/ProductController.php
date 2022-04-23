<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Produit;
use App\Form\CartType;
use App\Repository\CategorieRepository;
use App\Repository\ContenanceRepository;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            
            $recc = [];
            foreach($produit->getRecommandations() as $prod)
            {
                $recc[] = $prod->getRecommend();
            }
            return $this->render('/product/show.html.twig', [
                'produit' => $produit,
                'recommandations' => $recc
            ]);
        } else {
            $this->addFlash("danger", "Le produit recherché n'existe pas.");
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/category', name: 'app_product_category')]
    public function category(CategorieRepository $cr, $min = 1, $max = 400, $cat = 'default',  ProduitRepository $pr): Response
    {
        $produits = $pr->findAll();
        if(isset($_POST['filter']))
        {
            if(is_numeric(($_POST['filterCat'])))
            {
                $id = intval($_POST['filterCat']);
                if($id != -1 AND $cr->find($id))
                {
                    $produits = $pr->findBy(array('category' => $id));
                } 

                $cat = $id;
            }

            if(is_numeric($_POST['filterMin']) && is_numeric($_POST['filterMax']))
            {
                $prod = [];
                foreach($produits as $produit)
                {
                    if(($produit->getLowPrice() >= intval($_POST['filterMin'])) && ($produit->getLowPrice() <= intval($_POST['filterMax']))) {
                        $prod[] = $produit;
                    }
                }

                $min = intval($_POST['filterMin']);
                $max = intval($_POST['filterMax']);
                $produits = $prod;
            }
        }
   
        
        return $this->render("/product/category.html.twig", [
            "products" => $produits,
            "categories" => $cr->findAll(),
            "min"=> $min,
            "max" => $max,
            "cat" => $cat
        ]);
    }

    #[Route('/review/add/{id}', methods: ["POST"], name: 'app_product_review_add')]
    public function addReview($id, ProduitRepository $pr, EntityManagerInterface $entityManager) 
    {
        if(!$pr->find($id)) return $this->redirectToRoute('app_home');
        if(isset($_POST['review']))
        {
            if(isset($_POST['avis']) && !empty($_POST['avis'])) 
            {
                if(!isset($_POST['rateReview'])) { $rate = 0; } else {  $rate = intval($_POST['rateReview']); }
                if(is_numeric($rate) && (intval($rate) >= 0 && intval($rate) <= 5))
                {
                    $avis = htmlspecialchars($_POST['avis']);

                    $note = new Note();
                    $note->setAvis($avis);
                    $note->setIdClient($this->getUser());
                    $note->setProduit($pr->find($id));
                    $note->setNote($rate);    

                    $entityManager->persist($note);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_product_show', ['id'=>$id]);
                } else 
                return $this->redirectToRoute('app_product_show', ['id'=>$id]);
            } else 
            return $this->redirectToRoute('app_product_show', ['id'=>$id]);
        } else 
        return $this->redirectToRoute('app_product_show', ['id'=>$id]);
    }
    

    #[Route('/ajax', methods: ['POST'], name:'app_ajax')]
    public function ajax(Request $request, ContenanceRepository $cr) :JsonResponse
    {
        $stock = 0;
        $id = $request->request->get('id');
        if($cr->find($id))
        {
            $stock = $cr->findOneBy(array('id' => $id));
            $stock = $stock->getStock();

            $crr  = $cr->find($id)->getPrix();

        return new JsonResponse(array(
            'status' => 'Prix',
            'message' => [$crr,$stock]),
        200);
        }
    }
}
