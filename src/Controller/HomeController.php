<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/search', name: 'app_home_search')]
    #[Route('/search/category/{id}', name: 'app_home_search_category')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, Request $request, Category $category=null): Response
    {
        $routeName = $request->attributes->get("_route");

        if($routeName ==="app_home_search"){

            $value = $request->get('search');
            $products = $productRepository->findByExampleField($value);

            if (!$value) {
                return $this->redirectToRoute('app_home');
            }

            return $this->render('home/index.html.twig', [
                'products'=>$products,
                'categories'=>$categoryRepository->findAll(),
            ]);
        }

        if($routeName ==="app_home_search_category"){


            if (!$category) {
                return $this->redirectToRoute('app_home');
            }

            return $this->render('home/index.html.twig', [
                'products'=>$category->getProducts(),
                'categories'=>$categoryRepository->findAll(),
            ]);
        }

        return $this->render('home/index.html.twig', [
            'products'=>$productRepository->findAll(),
            'categories'=>$categoryRepository->findAll(),
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


    #[Route('/createfacture/{id}', name:'send_mail')]
    public function testmail(Order $order, MailerInterface $mailer, Environment $environment, Pdf $pdfmaker) {


        $html = $environment->render('my_order/show.html.twig',[
            'order'=>$order
        ]);
        $pdf = $pdfmaker->getOutputFromHtml($html);

        // pour créer le fichier et le stocker dans public
        // $pdfmaker->generateFromHtml($html,"facture.pdf");

        $mailUser = $this->getUser()->getEmail();

        $email = (new Email())
            ->from('contact@thomascarrot.com')


            ->to($mailUser)

            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')



            //pour attacher le PDF au mail
            ->attach($pdf, sprintf('facture.pdf'));

        $mailer->send($email);
        // dd($email);

        return $this->redirectToRoute('app_home');
    }
}
