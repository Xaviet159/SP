<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('admin/projects.html.twig', [
            'projects' => $projects
        ]);
    }
    /**
     * @Route("/admin/project/{id}/check_false", name="project_check_false")
     */
    public function checkFalse($id, ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $project = $projectRepository->find($id);

        if($project){
          $project->setIsValid(true);
          $em->persist($project);
          $em->flush();
          
          return $this->redirectToRoute('admin_projects');
        }  
    }
    /**
     * @Route("/admin/project/{id}/check_true", name="project_check_true")
     */
    public function checkTrue($id, ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $project = $projectRepository->find($id);

        if($project){
          $project->setIsValid(false);
          $em->persist($project);
          $em->flush();
          
          return $this->redirectToRoute('admin_projects');
        }
    }
}
