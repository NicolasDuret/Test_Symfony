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
        return $this->render('produits/_produit.html.twig', [
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

        return $this->render('produits/formulaire.html.twig', [
            'formulaire' => $formulaire->createView(),
            'h1' => "Ajouter un produit"
        ]);
    }

    /**
     * @Route("/produits/supprimer/{id}", name="produit_supprimer")
     */
    public function supprimer(Request $request, $id)
    {


        //je vais chercher l'objet à supprimer
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Produit::class);
        $produit = $repository->find($id);

        $em->remove($produit);
        $em->flush();

        return $this->render('produits/_produit.html.twig', [
            "produits" => $produit,
            'controller_name' => 'ProduitsController',
        ]);
    }


    /**
     * @Route("/produits/modifier/{id}",name="produit_modifier")
     */
    public function modifier(Request $request, $id){

        $repository=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$repository->find($id);
        $formulaire=$this->createForm(FormulaireType::class, $produit);
        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $em=$this->getDoctrine()->getManager();

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute("produits");
        }

        return $this->render('produits/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView(),
            "h1"=>"Modifier une catégorie".$produit->getNom()
        ]);
    }

}
