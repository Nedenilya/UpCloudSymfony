<?php

namespace App\Controller;

use App\Entity\Uploads;
use App\Entity\Archive;
use App\Entity\History;
use App\Form\FilesType;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;

class ArchiveController extends AbstractController
{
    /**
     * @Route("/archive", name="archive")
     */
    public function index(): Response
    {
        $user = $this->getUser();

    	$archive = $this->getDoctrine()
                ->getRepository(Archive::class)
                ->findAll2($user->getId());
            
        $uploadsSize = explode(' ', $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAllSize($user->getId())
            )[0];

        $history = $this->getDoctrine()
                ->getRepository(History::class)
                ->findAll2($user->getId());
        
        $scale = round(explode(' ', $uploadsSize)[0]/1024/1024/1024, 0);

        if($uploadsSize > 1000 && $uploadsSize < 1000000)
            $uploadsSize = round($uploadsSize/1024, 0).' Kb';
        elseif($uploadsSize > 1000000 && $uploadsSize < 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024, 1).' Mb';
        elseif($uploadsSize > 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024/1024, 1).' Gb';
        else
            $uploadsSize = '0 Gb';

        if (!$archive) {
            $this->addFlash('message', 'You have no archive records yet :)');
        }

        if (!$history) {
            $this->addFlash('message-history', 'You have no history yet :)');
        }

        return $this->render('archive/index.html.twig', [
            'items' => $archive,
            'available_space' => $uploadsSize,
            'all_space' => '1 Gb',
            'scale' => $scale,
            'history' => $history
        ]);
    }

    /**
     * @Route("/archive/delete/{id}", name="archive_delete")
     */
    public function delete($id){
        $entityManager = $this->getDoctrine()->getManager();

        $file = $this->getDoctrine()
            ->getRepository(Archive::class)
            ->findById($id);

        $res = $this->getDoctrine()
            ->getRepository(Archive::class)
            ->deleteItem($id);
       
        $archive = $this->getDoctrine()
                ->getRepository(Archive::class)
                ->findAll2($user->getId());
            
        $uploadsSize = explode(' ', $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAllSize($user->getId())
            )[0];

        $history2 = new History();

        $date = date("d.m.Y").'';
        $history2->setDate($date);
        $history2->setFileId($file[0]->getFileId());
        $history2->setFileName($file[0]->getFileName().'.'.$file[0]->getExtension());
        $history2->setMessage('was deleted from archive');

        $scale = round(explode(' ', $uploadsSize)[0]/1024/1024/1024, 0);

        if($uploadsSize > 1000 && $uploadsSize < 1000000)
            $uploadsSize = round($uploadsSize/1024, 0).' Kb';
        elseif($uploadsSize > 1000000 && $uploadsSize < 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024, 1).' Mb';
        elseif($uploadsSize > 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024/1024, 1).' Gb';
        else
            $uploadsSize = '0 Gb';

        if (!$archive) {
            $this->addFlash('message', 'You have no archive records yet :)');
        }

        $entityManager->persist($history2);
        $entityManager->flush();

        $history = $this->getDoctrine()
                    ->getRepository(History::class)
                    ->findAll();
        if (!$history) {
            $this->addFlash('message-history', 'You have no history yet :)');
        }
        //return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('archive/index.html.twig', [
            'items' => $archive,
            'available_space' => $uploadsSize,
            'all_space' => '1 Gb',
            'scale' => $scale,
            'history' => $history
        ]);
    }

}
