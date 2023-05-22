<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Product;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends AbstractController
{
    #[Route('/rate/{id}/mark/{mark}', name: 'app_rate')]
    public function index(Product $product, NoteRepository $noteRepository, EntityManagerInterface $manager, $mark = null): Response
    {
        $profile = $this->getUser()->getProfile();

        if(!$profile || !$product){

            $this->addFlash('danger', 'failed rating attempt');
            return $this->redirectToRoute('app_home');
        }

        if(!ctype_digit($mark)){

            $this->addFlash('danger', 'failed rating attempt');
            return $this->redirectToRoute('app_home');
        }

        if($mark < 0 || $mark > 5){

            $this->addFlash('danger', 'failed rating attempt');
            return $this->redirectToRoute('app_home');
        }

        //checker l'existence d'un rate

        $rate = $noteRepository->findOneBy([
            'author'=>$profile,
            'product'=>$product
        ]);

        if(!$rate){
            $rate = new Note();
            $rate->setAuthor($profile);
            $rate->setProduct($product);
        }

        $rate->setMark($mark);
        $manager->persist($rate);
        $manager->flush();

        return $this->redirectToRoute('app_show_product', ['id'=>$product->getId()]);
    }
}
