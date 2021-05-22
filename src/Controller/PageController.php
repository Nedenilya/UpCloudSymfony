<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Uploads;
use App\Entity\History;
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
        $user = $this->getUser();
        // $uploadsSize = '';
        // $history = null;
        // $scale = 0;

        if($user){
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

            return $this->render('main/index.html.twig', [
                'available_space' => $uploadsSize,
                'all_space' => '1 Gb',
                'scale' => $scale,
                'history' => $history
            ]);
        }
        return $this->redirectToRoute('app_register');
        // return $this->render('registration/register.html.twig', [
        //         'available_space' => $uploadsSize,
        //         'all_space' => '1 Gb',
        //         'scale' => $scale,
        //         'history' => $history
        //     ]);
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
