<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Uploads;
use App\Entity\History;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request) : Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/upload_avatar", name="user_upload_avatar")
     */
    public function upload_avatar(): Response
    {   
        $user = $this->getUser();
        $uploads = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAll2($user->getId());
    
        
        $uploadsSize = explode(' ', $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAllSize($user->getId())
        )[0];

        $history = $this->getDoctrine()
            ->getRepository(History::class)
            ->findAll2($user->getId());
            
        $scale = ($uploadsSize/1024/1024/1024)*100;

        if($uploadsSize > 1000 && $uploadsSize < 1000000)
            $uploadsSize = round($uploadsSize/1024, 0).' Kb';
        elseif($uploadsSize > 1000000 && $uploadsSize < 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024, 1).' Mb';
        elseif($uploadsSize > 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024/1024, 1).' Gb';
        else
            $uploadsSize = '0 Gb';

        if(isset($_FILES['file'])){
            $file = $_FILES['file']['tmp_name'];
            // $targ = "../images/".$_FILES['file']['name'];
            $path = $this->getParameter('default_profile_image_upl').'\\'.$_FILES['file']['name'];
            move_uploaded_file($file, $path);

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)
                ->find($_POST['user_id']);

            $user->setProfileImage('\images\\'.$_FILES['file']['name']);
            $entityManager->flush();
        }

        header('Location: '.$this->getParameter('home'));

        return $this->render('main/index.html.twig', [
            'available_space' => $uploadsSize,
            'all_space' => '1 Gb',
            'scale' => $scale, 
            'history' => $history
        ]);
    }    
}
