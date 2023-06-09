<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
         $categories = $categoryRepository->findAll();
         return $this->render(
             'category/index.html.twig',
             ['categories' => $categories]
         );
    }
    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);   
            return $this->redirectToRoute('category_index'); 
        }
    
        // Render the form
        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name'=>$categoryName]);
        $programs = $programRepository->findBy(['category'=>$category], ['id'=>'DESC'], 3);


        if (!$category){
            throw $this->createNotFoundException(
                'No category with name :' . $categoryName . 'found in category table'
            );
        }
        
        return $this->render('category/show.html.twig', ['category' => $category,'programs'=>$programs]);
    }
}