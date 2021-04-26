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
        $uploadsSize = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAllSize();

        $history = $this->getDoctrine()
            ->getRepository(History::class)
            ->findAll();
        
        if($uploadsSize > 1000)
            $uploadsSize = round($uploadsSize/1024, 1).' Mb';
        elseif($uploadsSize > 1000000)
            $uploadsSize = round($uploadsSize/1024/1024, 1).' Gb';
        else
            $uploadsSize = '0 Gb';
 
        $scale = round(explode(' ', $uploadsSize)[0]/10, 0);

        return $this->render('main/index.html.twig', [
            'available_space' => $uploadsSize,
            'all_space' => '1 Gb',
            'scale' => $scale,
            'history' => $history
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
