<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Contenance;
use App\Service\FileUploader;
use App\Entity\Recommandation;
use Doctrine\ORM\EntityManager;
use App\Service\Form\FormService;
use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\CategorieRepository;
use App\Repository\ContenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecommandationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_SALARIE', statusCode: 404, message: 'Page not found')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/ajax', methods: ['POST'], name:'app_admin_ajax')]
    public function ajax(Request $request, CommandeRepository $cr) :JsonResponse
    {
        $year = $request->request->get('year');
        if(strlen($year) == 4)
        {
            $data = [
                $cr->findByYear("01", $year)[0][1],
                $cr->findByYear("02", $year)[0][1],
                $cr->findByYear("03", $year)[0][1],
                $cr->findByYear("04", $year)[0][1],
                $cr->findByYear("05", $year)[0][1],
                $cr->findByYear("06", $year)[0][1],
                $cr->findByYear("07", $year)[0][1],
                $cr->findByYear("08", $year)[0][1],
                $cr->findByYear("09", $year)[0][1],
                $cr->findByYear("10", $year)[0][1],
                $cr->findByYear("11", $year)[0][1],
                $cr->findByYear("12", $year)[0][1]
            ];
            return new JsonResponse(array(
                'status' => 'Prix',
                'message' => [
                    $year,
                    $data
                ]),
            200);
        }
    }

    #[Route('/admin/stats/{year}', name: 'app_admin_stats')]
    public function statistics(int $year = 2022, CommandeRepository $cr): Response
    {
        if(isset($_POST['submitDate']))
        {
            if(isset($_POST['date']))
            {
                return $this->redirectToRoute('app_admin_stats', ['year' => $_POST['date']]);
            }
        }

        $count = $cr->findByYear("01", $year)[0][1] +
        $cr->findByYear("02", $year)[0][1] +
        $cr->findByYear("03", $year)[0][1] +
        $cr->findByYear("04", $year)[0][1] +
        $cr->findByYear("05", $year)[0][1] +
        $cr->findByYear("06", $year)[0][1] +
        $cr->findByYear("07", $year)[0][1] +
        $cr->findByYear("08", $year)[0][1] +
        $cr->findByYear("09", $year)[0][1] +
        $cr->findByYear("10", $year)[0][1] +
        $cr->findByYear("11", $year)[0][1] +
        $cr->findByYear("12", $year)[0][1];

        $years = [];
        
        foreach($cr->findAll() as $com)
        {
            if(!array_key_exists($com->getDateCommande()->format('Y'), $years))  array_push($years, $com->getDateCommande()->format('Y'));
        }
        $years = array_unique($years);

        return $this->render('admin/statistics.html.twig', [
            'controller_name' => 'AdminController',
            'year' => $year,
            'actualDate' => date('Y'),
            'years' => $years,
            'count' => $count
        ]);
    }
  
    #[IsGranted('ROLE_ORDER', statusCode: 404, message: 'Page not found')]
    #[Route('/admin/orders', name: 'app_admin_show_orders')]
    public function showOrders(CommandeRepository $cr)
    {
        $commandes = $cr->findAll();
        return $this->render('admin/showOrders.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[IsGranted('ROLE_ORDER', statusCode: 404, message: 'Page not found')]
    #[Route('/admin/order/{id}', name: 'app_admin_manage_order')]
    public function showOrder(int $id, CommandeRepository $cr, EntityManagerInterface $em)
    {
        if($cr->find($id))
        {
            $commande = $cr->find($id);

            if(isset($_POST['changeState']))
            {
                if(isset($_POST['selectState']))
                { 
                    dump("oui2");
                    $statut = $_POST['selectState'];
                    if(FormService::isset('dateState')) {
                        $date = new \DateTime($_POST['dateState']);
                        $commande->setDateLivraison($date);
                    }
                    $commande->setStatus($statut);

                    $em->persist($commande);
                    $em->flush();
                    return $this->redirectToRoute('app_admin_show_orders');
                }
            }

            if($commande->getDateLivraison() != null)
            {
                $date = $commande->getDateLivraison()->format('d-m-Y');
            } else {
                $date = date("d-m-Y");
            }
            return $this->render('admin/manageOrder.html.twig', [
                'commande' => $commande,
                'statut' => $commande->getStatus(),
                'dateLivraison' => $date
            ]);
        }
    }

    #[IsGranted('ROLE_STOCK', statusCode: 404, message: 'Page not found')]
    #[Route('/admin/products', name: 'app_admin_show_products')]
    public function showProduct(ProduitRepository $pr)
    {
        $products = $pr->findAll();
        return $this->render('admin/showProduct.html.twig', [
            'produits' => $products
        ]);
    }

    #[IsGranted('ROLE_STOCK', statusCode: 404, message: 'Page not found')]
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

    #[IsGranted('ROLE_STOCK', statusCode: 404, message: 'Page not found')]
    #[Route('/admin/product/promote/{id}', name:'app_admin_updateStatus_product')]
    public function promoteProduct(int $id, ProduitRepository $pr, EntityManagerInterface $em)
    {
        $produit = $pr->find($id);
        if($produit)
        {
            if($produit->getEnAvant() == null || $produit->getEnAvant() == false)
            {
                $produit->setEnAvant(true);
            } else {
                $produit->setEnAvant(false);
            }
            $em->persist($produit);
            $em->flush();
        }
        return $this->redirectToRoute('app_admin_show_products');
    }


    #[Route('/admin/products/affiliate', name:'app_admin_affiliation')]
    public function affiliate(ProduitRepository $pr, EntityManagerInterface $em, RecommandationRepository $rr)
    {
        if(isset($_POST['createAffiliation']))
        {
            $produit = $_POST['product'];
            $recommend = $_POST['recommend'];

            $prod = $pr->find($produit);
            $recommend = $pr->find($recommend);

            $recomm = new Recommandation();
            $recomm->setProduit($prod);
            $recomm->setRecommend($recommend);

            $em->persist($recomm);
            $em->flush();

            return $this->redirectToRoute('app_admin_affiliation');
        }
        if(isset($_POST['deleteRecomm']))
        {
            $recommandation = $rr->find($_POST['idRecomm']);


            $em->remove($recommandation);
            $em->flush();
            return $this->redirectToRoute('app_admin_affiliation');
        }
        return $this->render('admin/affiliateProduct.html.twig', [
            'produits' => $pr->findAll(),
            'recommandations' => $rr->findAll()
        ]);
    }


    #[Route('/admin/client/{id}', name:'app_admin_show_client')]
    public function viewClient(int $id, ClientRepository $cr, EntityManagerInterface $em)
    {
        if($cr->find($id))
        {
            $client = $cr->find($id);
            if(isset($_POST['editRole']))
            {
                $admin = 0;
                $order = 0;
                $salarie = 0;
                $stock = 0;
                if(isset($_POST['admin']) AND htmlspecialchars($_POST['admin']) == 'on') $admin = 1;
                if(isset($_POST['orderManager']) AND htmlspecialchars($_POST['orderManager']) == 'on') $order = 1;
                if(isset($_POST['salarie']) AND htmlspecialchars($_POST['salarie']) == 'on') $salarie = 1;
                if(isset($_POST['stockManager']) AND htmlspecialchars($_POST['stockManager']) == 'on') $stock = 1;

                $client->updateRole($admin, $order, $stock,$salarie);
                $em->persist($client);
                $em->flush();
                return $this->redirectToRoute('app_admin');
            } else {
                return $this->render('admin/manageRoles.html.twig', [
                    'client' => $client
                ]);
            }
        }
        return $this->redirectToRoute('app_admin_show_clients');
    }


    #[Route('/admin/clients', name:'app_admin_show_clients')]
    public function viewClients(ClientRepository $cr)
    {
        return $this->render('admin/showAccount.html.twig', [
            'clients' => $cr->findAll()
        ]);
    }

    
    #[IsGranted('ROLE_STOCK', statusCode: 404, message: 'Page not found')]
    #[Route('/admin/products/manage/{id}', name:'app_admin_manage_product')]
    public function manageStock(int $id, ProduitRepository $pr, EntityManagerInterface $em, ContenanceRepository $cr)
    {
        $produit = $pr->find($id);
        $stock = $produit->getContenances();
        if(isset($_POST['manageStock']))
        {
            if(isset($_POST['contenanceQte']) && count($_POST['contenanceQte']) > 0 && is_array($_POST['contenanceQte']))
            {
                
                $produit->removeContenances();
                $count = count($_POST['contenanceQte']);
                for($i = 0; $i < $count; $i++){
                    $contenance = new Contenance();
                    $contenance->setPrix($_POST['contenancePrix'][$i])
                               ->setStock($_POST['contenanceStock'][$i])
                               ->setQuantite($_POST['contenanceQte'][$i])
                               ->setUnite($_POST['contenanceUnite'][$i]);
                    $produit->addContenance($contenance);
                }
                $em->persist($produit);
                $em->flush();
                return $this->redirectToRoute('app_admin_show_products');
            }
        }
        return $this->render('admin/manageStock.html.twig', [
            'produit' => $produit,
            'stock' => $stock
        ]);
    }

    #[IsGranted('ROLE_STOCK', statusCode: 404, message: 'Page not found')]
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
