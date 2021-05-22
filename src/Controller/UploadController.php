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
        $user = $this->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $ext = array('css', 'doc', 'docx', 'exe', 'gif', 'html', 'jpeg', 'jpg', 'js', 'json', 'mp3', 'mp4', 'pdf', 'png', 'ppt', 'pptx', 'rar', 'txt', 'xls', 'xml');
            $file = $form['fileName']->getData();
            
            $date = date("d.m.Y").'';
            
            $upload->setUserId($user->getId());
            $history->setFileName($file->getClientOriginalName());
            $history->setUserId($user->getId());
            $upload->setUploaded($date);
            $upload->setArchived(false);
            $history->setDate($date);
            $history->setMessage('was uploaded');

            $arr = explode('.',$file->getClientOriginalName());

            $extension = end($arr);
            if ($extension) {
                $upload->setExtension($extension);
                if(!in_array($extension, $ext))
                    $upload->setExtension2('none');
                else
                    $upload->setExtension2($extension);
            }else{
                $extension = '';
            }

            $upload->setFileName(explode('.'.$extension, $file->getClientOriginalName())[0]);

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $safeFilename = sha1($safeFilename);
            $newFilename = $safeFilename.'.'.$extension;
            $upload->setHashName($newFilename);

            try {
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('upload_error', 'File not uploaded');
            }

            $filesize = round(filesize($this->getParameter('uploads_directory').'/'.$newFilename), 0);
            $upload->setSize($filesize);

            if($filesize > 1000 && $filesize < 1000000)
                $filesize = round($filesize/1024, 0).' Kb';
            elseif($filesize > 1000000 && $filesize < 1000000*1000)
                $filesize = round($filesize/1024/1024, 1).' Mb';
            elseif($filesize > 1000000*1000)
                $filesize = round($filesize/1024/1024/1024, 1).' Gb';
            else
                $filesize = '0 Gb';
            $upload->setSize2($filesize);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($upload);
            $entityManager->flush();

            $history->setFileId($upload->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($history);
            $entityManager->flush();

            $this->addFlash('success_upload', 'File uploaded');
        }

        $uploadsSize = 0;
        if($user){
            $uploadsSize = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAllSize($user->getId()
            );
        }
                
        $scale = ($uploadsSize/1024/1024/1024)*100;
        
        if($uploadsSize > 1000 && $uploadsSize < 1000000)
            $uploadsSize = round($uploadsSize/1024, 0).' Kb';
        elseif($uploadsSize > 1000000 && $uploadsSize < 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024, 1).' Mb';
        elseif($uploadsSize > 1000000*1000)
            $uploadsSize = round($uploadsSize/1024/1024/1024, 1).' Gb';
        else
            $uploadsSize = '0 Gb';

        return $this->render('upload/upload_files.html.twig', [
            'uploadForm' => $form->createView(),
            'available_space' => $uploadsSize,
            'all_space' => '1 Gb',
            'scale' => $scale,
        ]);
    }

    /**
     * @Route("/uploads", name="uploads_show")
     */
    public function show()
    {
        $user = $this->getUser();

        if($user){
            if(isset($_POST['title'])){
                $uploads = $this->getDoctrine()
                    ->getRepository(Uploads::class)
                    ->findByTitle($_POST['title'], $user->getId());
            }else{
                $uploads = $this->getDoctrine()
                    ->getRepository(Uploads::class)
                    ->findAll2($user->getId());
            }
                
            $uploadsSize = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAllSize($user->getId()
            );

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

            if (!$uploads) {
                $this->addFlash('message', 'You have no uploads yet :)');
            }

            if (!$history) {
                $this->addFlash('message-history', 'You have no history yet :)');
            }

            return $this->render('upload/uploads.html.twig', [
                'items' => $uploads,
                'available_space' => $uploadsSize,
                'all_space' => '1 Gb',
                'scale' => $scale,
                'history' => $history
            ]);
        }

        return $this->redirectToRoute('app_register');
    }

    /**
     * @Route("/uploads/detail/{id}", name="uploads_detail")
     */
    public function detail($id = null)
    {
        $user = $this->getUser();
        if($user){
            if($id != null){
                $uploads = $this->getDoctrine()
                    ->getRepository(Uploads::class)
                    ->findById($id);
            
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
            }

            return $this->render('main/detail.html.twig', [
                'items' => $uploads,
                'available_space' => $uploadsSize,
                'all_space' => '1 Gb',
                'scale' => $scale,
                'history' => $history
            ]);
        }
        return $this->redirectToRoute('app_register');
    }

    /**
     * @Route("/uploads/download/{id}", name="uploads_download")
     */
    public function download($id = null){
        $user = $this->getUser();
        if($user){
            if($id != null){
                $filenamearr = $this->getDoctrine()
                    ->getRepository(Uploads::class)
                    ->getFileNameById($id);

                $filename = $this->getParameter('uploads_directory').'\\'.$filenamearr[0]['hashName'];

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
         
                if(ini_get('zlib.output_compression'))
                  ini_set('zlib.output_compression', 'Off');
                  
                $file_extension = strtolower(substr(strrchr($filename,"."),1));
                  
                if($filename == ""){
                      echo "ОШИБКА: УКАЖИТЕ ИМЯ ФАЙЛА.";
                      exit;
                }
                if(!file_exists($filename)){
                      echo "ОШИБКА: данного файла не существует. ".$filename;
                      exit;
                }

                switch($file_extension){
                    case "pdf": $ctype="application/pdf"; break;
                    case "exe": $ctype="application/octet-stream"; break;
                    case "zip": $ctype="application/zip"; break;
                    case "doc": $ctype="application/msword"; break;
                    case "docx": $ctype="application/msword"; break;
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
                header("Content-Type: ".$ctype);
                header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: ".filesize($filename));
                readfile($filename.'');

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
        return $this->redirectToRoute('app_register');
    }

    /**
     * @Route("/uploads/delete/{id}", name="uploads_delete")
     */
    public function delete($id){
        $user = $this->getUser();
        if($user){
            $entityManager = $this->getDoctrine()->getManager();

            $file = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findById($id);
           
            $res = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->deleteItem($id);

            $uploads = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAll2($user->getId());
                
            $uploadsSize = $this->getDoctrine()
                ->getRepository(Uploads::class)
                ->findAllSize($user->getId()
            );

            $history2 = new History();

            $date = date("d.m.Y").'';
            $history2->setDate($date);
            $history2->setUserId($user->getId());
            $history2->setFileId($file[0]->getId());
            $history2->setFileName($file[0]->getFileName());
            $history2->setMessage('was deleted');

            unlink($this->getParameter('uploads_directory').'/'.$file[0]->getHashName());

            $scale = ($uploadsSize/1024/1024/1024)*100;

            if($uploadsSize > 1000 && $uploadsSize < 1000000)
                $uploadsSize = round($uploadsSize/1024, 0).' Kb';
            elseif($uploadsSize > 1000000 && $uploadsSize < 1000000*1000)
                $uploadsSize = round($uploadsSize/1024/1024, 1).' Mb';
            elseif($uploadsSize > 1000000*1000)
                $uploadsSize = round($uploadsSize/1024/1024/1024, 1).' Gb';
            else
                $uploadsSize = '0 Gb';
            
            if (!$uploads) {
                $this->addFlash('message', 'You have no uploads yet :)');
            }

            $entityManager->persist($history2);
            $entityManager->flush();

            $history = $this->getDoctrine()
                        ->getRepository(History::class)
                        ->findAll2($user->getId());

            //return new Response('Check out this great product: '.$product->getName());

            // or render a template
            // in the template, print things with {{ product.name }}
            return $this->render('upload/uploads.html.twig', [
                'items' => $uploads,
                'available_space' => $uploadsSize,
                'all_space' => '1 Gb',
                'scale' => $scale,
                'history' => $history
            ]);
        }
        return $this->redirectToRoute('app_register');
    }


    /**
     * @Route("/uploads/archive/{id}", name="uploads_archive")
     */
    public function archive($id)
    {
        $user = $this->getUser();
        if($user){
            if($id){

                $entityManager = $this->getDoctrine()->getManager();

                $uploads = $this->getDoctrine()
                    ->getRepository(Uploads::class)
                    ->findAll2($user->getId());

                $upload = $entityManager->getRepository(Uploads::class)
                    ->find($id);
                $upload2 = $entityManager->getRepository(Uploads::class)
                    ->findById($id);

                $uploadsSize = $this->getDoctrine()
                    ->getRepository(Uploads::class)
                    ->findAllSize($user->getId()
                );

                $history2 = new History();


                $archive2 = $this->getDoctrine()
                    ->getRepository(Archive::class)
                    ->findByName($upload->getFileName(), $user->getId());

                if (!$archive2) {
                    $archive = new Archive();
                    
                    $archive->setFileName($upload->getFileName());
                    $archive->setUserId($user->getId());
                    $archive->setFileId($upload->getId());
                    $archive->setSize($upload->getSize());
                    $archive->setSize2($upload->getSize2());
                    $archive->setExtension($upload->getExtension());
                    $archive->setExtension2($upload->getExtension2());
                    $archive->setUploaded($upload->getUploaded());

                    $upload->setArchived(true);
                    $date = date("d.m.Y").'';
                    $history2->setDate($date);
                    $history2->setUserId($user->getId());
                    $history2->setFileName($upload->getFileName());
                    $history2->setMessage('was archived');

                    // rename($this->getParameter('uploads_directory').'\\'.$upload->getHashName(), 
                    //     $this->getParameter('archive_directory').'\\'.$upload->getHashName()
                    // );
                    copy($this->getParameter('uploads_directory').'\\'.$upload->getHashName(), 
                        $this->getParameter('archive_directory').'\\'.$upload->getHashName()
                    );

                    $entityManager->persist($archive);
                    $entityManager->flush();

                    

                }else{
                    $this->addFlash('message-archive', 'Данный файл уже заархивирован :)');
                }

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
            }

            return $this->render('main/detail.html.twig', [
                'items' => $upload2,
                'available_space' => $uploadsSize,
                'all_space' => '1 Gb',
                'scale' => $scale,
                'history' => $history
            ]);
        }
        return $this->redirectToRoute('app_register');
    }


}
