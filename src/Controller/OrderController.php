<?php

namespace App\Controller;

use App\Entity\Address;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/selectaddress', name: 'app_select_address')]
    public function index(): Response
    {
        return $this->render('order/select_address.html.twig', [
        ]);
    }

    #[Route('/payment/{id}', name: 'app_payment')]
    public function payment(Address $address): Response
    {
        return $this->render('order/payment.html.twig', [
            'address'=>$address
        ]);
    }

    #[Route('/makeorder/{id}', name: 'app_make_order')]
    public function makeorder(Address $address, CartService $cartService, EntityManagerInterface $manager): Response
    {

        return $this->redirectToRoute('');
    }


}
