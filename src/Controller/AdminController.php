<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', []);
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
    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function usersList(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }
    /**
     * @Route("/admin/user/{id}/edit", name="admin_user_edit")
     */
    public function userEdit($id, UserRepository $userRepository, EntityManagerInterface $em, Request $request)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        $formView = $form->createView();
        if($form->isSubmitted()){
          $em->flush();
          return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/edit_user.html.twig', [
            'user' => $user,
            'formView' => $formView
        ]);
    }
    /**
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     */
    public function userDelete($id, UserRepository $userRepository,PurchaseRepository $purchaseRepository, EntityManagerInterface $em)
    {
        // $purchase = $purchaseRepository->findby([
        //     'user' => $id
        // ]);
        $user = $userRepository->find($id);
        // if($purchase){
        //     $em->remove($purchase);
        //     $em->flush();
        //     return $this->redirectToRoute('admin_users');
        //   }
        if($user){
          $em->remove($user);
          $em->flush();
          return $this->redirectToRoute('admin_users');
        }

    }

}
