<?php

namespace App\Controller;

use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/selectaddress', name: 'app_select_address')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [

        ]);
    }
}
