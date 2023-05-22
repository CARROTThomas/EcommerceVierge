<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'products'=>$productRepository->findAll()
        ]);
    }

    #[Route('/show/{id}', name: 'app_show_product')]
    public function show(Product $product, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();

        return $this->renderForm('home/show.html.twig', [
            'product'=>$product,
            'formulaire_comment'=>$this->createForm(CommentType::class, $comment)
        ]);
    }

    #[Route('/createfacture', name:'send_mail')]
    public function testmail() {

    }
}
