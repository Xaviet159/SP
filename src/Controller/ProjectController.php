<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="projects")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projects    
        ]);
    }

    /**
     * @Route("/project/{id}/show", name="project_show")
     */
    public function show($id, ProjectRepository $projectRepository)
    {
        $project = $projectRepository->find($id);

        return $this->render('project/show.html.twig', [
            'id' => $id,
            'project' => $project
            
        ]);
    }

    /**
     * @Route("/project/create", name="project_create")
     */
    public function create(FormFactoryInterface $factory, Request $request, EntityManagerInterface $em, UserRepository $user)
    {
        $user = $this->getUser();
        $project = new Project;
    
        $form = $this->createForm(ProjectType::class);

            $form->handleRequest($request);

            if($form->isSubmitted()){
                $project->setUser($user);

                $em->persist($project);
                $em->flush();    
            }

            $formView = $form->createView();

        return $this->render('project/create.html.twig', [
            'formView' => $formView
        ]);
    }
    /**
     * @Route("/admin/project/{id}/edit", name="project_edit")
     */
    public function edit($id, ProjectRepository $projectRepository, Request $request, EntityManagerInterface $em)       
    {
        $project = $projectRepository->find($id);

        $form = $this->createForm(ProjectType::class);
        $form->setData($project);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em->flush();
            
        }
        $formView = $form->createView();

        return $this->render('admin/edit.html.twig', [
            'project' => $project,
            'formView' => $formView
        ]);
    }
}
