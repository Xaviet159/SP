<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('security_login');
        }

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
