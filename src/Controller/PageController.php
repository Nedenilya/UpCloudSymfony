<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername('Ilya')
             ->setEmail('nedenilya@gmail.com')
             ->setPassword('Ilya123')
             ->setRoles(array('ROLE_USER'));

        $entityManager->persist($user);
        $entityManager->flush();
        
        return $this->render('main/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function upload(): Response
    {
        return $this->render('upload/upload_files.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
