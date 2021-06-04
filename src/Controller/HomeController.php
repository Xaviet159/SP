<?php 

namespace App\Controller;

use App\Repository\ProjectRepository;
use Twig\Environment;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homePage")
     */
    public function homepage()
    {
        $user = $this->getUser();
        // count([])
        // find(id)
        // findBy([], [])
        // finOnBy([], [])
        // findAll()
        
        return $this->render('home/home.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("/home/rgpd", name="rgpd")
     */
    public function rgpd()
    {
        return $this->render('home/rgpd.html.twig', []);
    }
    /**
     * @Route("/home/cookies", name="cookies")
     */
    public function cookies()
    {
        return $this->render('home/cookies.html.twig', []);
    }
}