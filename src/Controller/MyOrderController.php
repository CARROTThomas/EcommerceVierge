<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my/order')]
class MyOrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render('my_order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_my_order_show', methods: ['GET'], priority: 2)]
    public function show(Order $order): Response
    {
        return $this->render('my_order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_my_order_edit', methods: ['GET', 'POST'])]
    public function edit(Order $order, Request $request, OrderRepository $orderRepository, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->save($order, true);
            return $this->redirectToRoute('app_order_index');
        }

        return $this->renderForm('my_order/edit.html.twig', [
            'order'=>$order,
            'form'=>$form
        ]);
    }
}
