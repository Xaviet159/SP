<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/projects", name="admin_projects")
     */
    public function list(ProjectRepository $projectRepository)
    {
        $projects = $projectRepository->findAll();
        dump($projects);
        return $this->render('admin/projects.html.twig', [
            'projects' => $projects
        ]);
    }
}
