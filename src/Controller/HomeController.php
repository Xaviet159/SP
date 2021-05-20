<?php 

namespace App\Controller;

use Twig\Environment;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('home.html.twig');
    }
}