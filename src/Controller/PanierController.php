<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="app_panier")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $delete_product_id=$request->query->get('delete','');
        if($delete_product_id) {
            $product =$this->getDoctrine()->getRepository(Product::class)->find($delete_product_id);
            $user->removeProduct($product);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        
        $products = $user->getProducts();
        return $this->render('panier/index.html.twig', [
            'products' => $products,
        ]);
    }
}
