<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MachinController extends AbstractController
{
    #[Route('/machin', name: 'app_machin')]
    public function index(): Response
    {
        return $this->render('machin/index.html.twig', [
            'controller_name' => 'MachinController',
        ]);
    }
}
