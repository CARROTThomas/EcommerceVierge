<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/data')]
class DataController extends AbstractController
{
    #[Route('/', name: 'app_data_index')]
    public function index(OrderRepository $orderRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $total = 0;
        $orders = $orderRepository->findAll();

        foreach ($orders as $order) {
            $total+=$order->getTotal();
        }
        return $this->render('data/index.html.twig', [
            'orderCount' => $orderRepository->count([]),
            'total'=>$total,
            'categoryCount' => $categoryRepository->count([]),
            'categoryProduct' => $productRepository->count([]),
        ]);
    }
}
