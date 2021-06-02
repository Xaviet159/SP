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
     * @Route("/projects", name="projects")
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
    public function create(Request $request, EntityManagerInterface $em, UserRepository $user)
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('security_login');
        }
        $project = new Project;
    
        $form = $this->createForm(ProjectType::class, $project);

            $form->handleRequest($request);

            if($form->isSubmitted()){
                $project->setUser($user);

                $em->persist($project);
                $em->flush();    

                return $this->redirectToRoute('projects');
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
            return $this->redirectToRoute('admin_projects');   
        }
        $formView = $form->createView();

        return $this->render('admin/edit.html.twig', [
            'project' => $project,
            'formView' => $formView
        ]);
    }
    /**
     * @Route("/admin/project/{id}/delete", name="project_delete")
     */
    public function delete($id, ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $project = $projectRepository->find($id);

        if($project){
            $em->remove($project);
            $em->flush();
            return $this->redirectToRoute('admin_projects');
        }
    }
}
