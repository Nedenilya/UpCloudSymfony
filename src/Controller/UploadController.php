<?php

namespace App\Controller;


use App\Entity\Uploads;
use App\Form\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends AbstractController
{
    
    public function index2(): Response
    {
        
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function index(Request $request)
    {
        $upload = new Uploads();
        $form = $this->createForm(FileType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            // if($form->get('password')->getData() === $form->get('passwordAgain')->getData()){
            //     $user->setPassword(
            //         $passwordEncoder->encodePassword(
            //             $user,
            //             $form->get('password')->getData()
            //         )
            //     );
            // }else{
            //     $this->addFlash('message', 'Passwords must be same');
            //     return $this->render('registration/register.html.twig', [
            //         'registrationForm' => $form->createView(),
            //     ]);
            // }

            // $user->setUsername($form->get('username')->getData());
            // $user->setEmail($form->get('email')->getData());
            // $user->setRoles(array('ROLE_USER'));

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($user);
            // $entityManager->flush();

           
            // return $guardHandler->authenticateUserAndHandleSuccess(
            //     $user,
            //     $request,
            //     $authenticator,
            //     'main' // firewall name in security.yaml
            // );
        }

        return $this->render('upload/upload_files.html.twig', [
            'fileForm' => $form->createView(),
        ]);
    }
}
