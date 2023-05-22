<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;

use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image')]
class ImageController extends AbstractController
{
    #[Route('/{id}', name: 'app_image_index')]
    public function index(Product $product): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        return $this->renderForm('image/index.html.twig', [
            'product' => $product,
            'form' => $form
        ]);
    }

    #[Route('addtoproduct/{id}', name: 'app_image_product_add')]
    #[Route('addtoprofile', name: 'app_image_profile_add')]
    public function addImage(Product $product = null, Request $request, EntityManagerInterface $manager): Response
    {
        $routeName = $request->attributes->get("_route");

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if($product && $routeName == "app_image_product_add"){
                $image->setProduct($product);
            }elseif($routeName == "app_image_profile_add"){

                $oldImage = $this->getUser()->getProfile()->getImage();

                if($oldImage){

                    $manager->remove($oldImage);
                }

                $image->setProfile($this->getUser()->getProfile());
            }
            $manager->persist($image);
            $manager->flush();
        }

        if($routeName == "app_image_profile_add"){
            return $this->redirectToRoute('app_myprofile');
        }

        return $this->redirectToRoute('app_image_index', ['id' => $product->getId()]);
    }

    #[Route('removefromproduct/{id}', name: 'app_image_delete')]
    public function removeFromProduct(Image $image, EntityManagerInterface $manager): Response
    {
        if ($image) {

            $product = $image->getProduct();
            $manager->remove($image);
            $manager->flush();
        }

        return $this->redirectToRoute('app_image_index', ['id' => $product->getId()], Response::HTTP_SEE_OTHER);
    }
}
