<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\FormulaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index()
    {
        $repository=$this->getDoctrine()->getRepository( Produit::class);
        $produits = $repository->findAll();
        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/produits/ajouter", name="produit_ajouter")
     */
    public function ajouter(Request $request)
    {
        $produit=new Produit();
        $formulaire=$this->createForm(FormulaireType::class, $produit);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $var=$this->getDoctrine()->getManager();
            $var->persist($produit);
            $var->flush();
            return $this->redirectToRoute("produits");
        }

        return $this->render('produits/fomulaire.html.twig', [
            'formulaire' => $formulaire->createView(),
            'h2' => "Ajouter un produit"
        ]);
    }
}
