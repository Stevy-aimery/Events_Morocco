<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Utilisez directement le repository pour récupérer les catégories
        $categories = $categoryRepository->findAll();

        // Passez les catégories au modèle Twig pour le rendu
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/show-categories', name: 'show_categories')]
    public function showCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAllWithEvents();

        return $this->render('category/showCat.html.twig', [
            'categories' => $categories,
        ]);
    }
    
   
}
