<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/data')]
class DataController extends AbstractController
{
    #[Route('/', name: 'app_data_index')]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('data/index.html.twig', [
            'orders' => $orderRepository->findAll()
        ]);
    }
}
