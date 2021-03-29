<?php

namespace App\Controller;


use App\Entity\Uploads;
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

class UploadController extends AbstractController
{

    /**
     * @Route("/upload_files", name="app_upload_files")
     */
    public function upload_files(Request $request, SluggerInterface $slugger) : Response
    {
        $upload = new Uploads();
        $form = $this->createForm(FilesType::class, $upload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['fileName']->getData();

            $upload->setFileName(explode('.',$file->getClientOriginalName())[0]);
            $upload->setUploaded(date("d.m.Y").'');

            $extension = explode('.',$file->getClientOriginalName())[1];
            if ($extension) {
                $upload->setExtension($extension);
            }else{
                $extension = '';
            }

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'.'.$extension;

            try {
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('upload_error', 'Files not uploaded');
            }

            $upload->setSize(round(filesize(
                $this->getParameter('uploads_directory').'/'.$newFilename) / 1024, 0).'');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($upload);
            $entityManager->flush();

            $this->addFlash('success_upload', 'Files uploaded');
        }

        return $this->render('upload/upload_files.html.twig', [
            'uploadForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/uploads", name="uploads_show")
     */
    public function show()
    {
        $uploads = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAll();
            
        $uploadsSize = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAllSize();
        
        if($uploadsSize > 10000)
            $uploadsSize = round($uploadsSize/1024, 1).' Mb';
        elseif($uploadsSize > 1000000)
            $uploadsSize = round($uploadsSize/1024/1024, 1).' Gb';
        else
            $uploadsSize = '0 Gb';

        $scale = round(explode(' ', $uploadsSize)[0]/10, 0);

        if (!$uploads) {
            throw $this->createNotFoundException(
                'No product found for id'
            );
        }

        //return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('upload/uploads.html.twig', [
            'items' => $uploads,
            'available_space' => $uploadsSize,
            'all_space' => '1 Gb',
            'scale' => $scale
        ]);
    }


}
