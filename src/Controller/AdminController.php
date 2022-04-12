<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ContenanceRepository;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use App\Service\FileUploader;
use App\Service\Form\FormService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/admin/products/delete/{id}', name:'app_admin_delete_product')]
    public function deleteProduct(int $id, ProduitRepository $pr, EntityManagerInterface $em)
    {
        $produit = $pr->find($id);
        if(isset($_POST['deleteProduct']))
        {
            $em->remove($produit);
            $em->flush();
            return $this->redirectToRoute('app_admin_show_products');
        }
        if($produit != null AND $produit instanceof Produit)
        {
            return $this->render('admin/confirmDeleteProduct.html.twig', [
                'produit' => $produit
            ]);
        }
        return $this->redirectToRoute('app_admin_show_products');
    }

    
    #[Route('/admin/products/manage/{id}', name:'app_admin_manage_product')]
    public function manageStock(int $id, ProduitRepository $pr)
    {
        $produit = $pr->find($id);
        return $this->render('admin/manageStock.html.twig', [
            'produit' => $produit,
            'stock' => $produit->getContenances()
        ]);
    }

    #[Route('/admin/products/create', name: 'app_admin_create_product')]
    public function createProduct(FileUploader $fu, EntityManagerInterface $em, CategorieRepository $cr, MarqueRepository $mr, ProduitRepository $pr)
    {
        if(isset($_POST['addProduct'])) 
        {
            $extension = pathinfo($_FILES["productImage"]["name"], PATHINFO_EXTENSION);
            if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
            {
            if(
                FormService::isset("productName") && 
                FormService::isset("productDesc") && 
                FormService::isset("productMarque") && 
                FormService::isset("productCategory") 
            ){
                $count = count($_POST["contenanceUnite"]) - 1;

                $nom = FormService::getString("productName");
                $desc = FormService::getString("productDesc");
                $cat = FormService::getString("productCategory");
                $marques = FormService::getString("productMarque");
                $marque = $mr->find($marques);
                $img = $fu->upload("productImage");
                $categorie = $cr->find($cat);
                $produit = new Produit();
                $produit
                    ->setNom($nom)
                    ->setIllustration($img)
                    ->setDescription($desc)
                    ->setMarque($marque)
                    ->setCategory($categorie);

                for($i = 0; $i <= $count; $i++)
                {
                    $contenance = new Contenance();
                    $contenance->setPrix($_POST['contenancePrix'][$i])
                               ->setStock($_POST['contenanceStock'][$i])
                               ->setQuantite($_POST['contenanceQte'][$i])
                               ->setUnite($_POST['contenanceUnite'][$i]);
                    $produit->addContenance($contenance);
                }

                $em->persist($produit);
                $em->flush();
                

            }
        } else {
            die("Le fichier doit être une image.");
        }
            return $this->redirectToRoute("app_admin_show_products");
        }
        return $this->render('admin/createProduct.html.twig', [
            "category" => $cr->findAll(),
            "marque" => $mr->findAll()
        ]);
    }

}
