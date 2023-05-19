<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my/order')]
class MyOrderController extends AbstractController
{
    #[Route('/', name: 'app_my_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('my_order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_my_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('my_order/show.html.twig', [
            'order' => $order,
        ]);
    }
}
