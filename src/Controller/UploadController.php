<?php

namespace App\Controller;


use App\Entity\Uploads;
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

class UploadController extends AbstractController
{

    /**
     * @Route("/upload_files", name="app_upload_files")
     */
    public function upload_files(Request $request, SluggerInterface $slugger) : Response
    {
        $upload = new Uploads();
        $history = new History();
        $form = $this->createForm(FilesType::class, $upload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['fileName']->getData();

            $date = date("d.m.Y").'';
            $upload->setFileName(explode('.',$file->getClientOriginalName())[0]);
            $history->setFileName($file->getClientOriginalName());
            $upload->setUploaded($date);
            $history->setDate($date);

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

            $history->setFileId($upload->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($history);
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
        if(isset($_POST['title'])){
            $uploads = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findByTitle($_POST['title']);
        }else{
            $uploads = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAll();
        }
            
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
            'scale' => $scale,
            'history' => $history,
            'filename' => ''
        ]);
    }

    /**
     * @Route("/uploads/download/{id}", name="uploads_download")
     */
    public function download($id = null){
        if($id != null){
            $filenamearr = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->getFileNameById($id);

            $filename = $this->getParameter('uploads_directory').'\\'.$filenamearr[0]['fileName'].'.'.$filenamearr[0]['extension'];
            $uploads = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAll();
        
            
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

            if(ini_get('zlib.output_compression'))
              ini_set('zlib.output_compression', 'Off');
              
            $file_extension = strtolower(substr(strrchr($filename,"."),1));
              
            if($filename == ""){
                  echo "ОШИБКА: УКАЖИТЕ ИМЯ ФАЙЛА.";
                  exit;
            }elseif(!file_exists($filename)){
                  echo "ОШИБКА: данного файла не существует.";
                  exit;
            }

            switch($file_extension){
                case "pdf": $ctype="application/pdf"; break;
                case "exe": $ctype="application/octet-stream"; break;
                case "zip": $ctype="application/zip"; break;
                case "doc": $ctype="application/msword"; break;
                case "xls": $ctype="application/vnd.ms-excel"; break;
                case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
                case "mp3": $ctype="audio/mp3"; break;
                case "gif": $ctype="image/gif"; break;
                case "png": $ctype="image/png"; break; 
                case "txt": $ctype="text/txt"; break;  
                case "jpeg":
                case "jpg": $ctype="image/jpg"; break;
                default: $ctype="application/force-download";
            }

            header("Pragma: public"); 
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false); 
            header("Content-Type: $ctype");
            header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".filesize($filename));
            readfile("$filename");

            return $this->render('upload/uploads.html.twig', [
                'items' => $uploads,
                'available_space' => $uploadsSize,
                'all_space' => '1 Gb',
                'scale' => $scale, 
                'history' => $history,
                'filename' => $filename
            ]);
        }
    }

    /**
     * @Route("/uploads/delete/{id}", name="uploads_delete")
     */
    public function delete($id){
        $res = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->deleteItem($id);
       
        $uploads = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAll();
            
        $uploadsSize = $this->getDoctrine()
            ->getRepository(Uploads::class)
            ->findAllSize();
        
        if($uploadsSize > 1000)
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
