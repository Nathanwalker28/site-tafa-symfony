<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Service\FileUploader;
use App\Form\CandidateRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader): Response
    {
        $candidate = new Candidate();

        $form = $this->createForm(CandidateRegisterType::class, $candidate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $url_resume = $form->get('url_resume')->getData();
            $url_cover_letter_resume = $form->get('url_cover_letter')->getData();
            if($url_resume) {
                $url_resume_name = $fileUploader->upload($url_resume);
                $url_cover_letter_name = $fileUploader->upload($url_cover_letter_resume);


                $candidate->setUrlResume($url_resume_name);
                $candidate->setUrlCoverLetter($url_cover_letter_name);
            }

            $manager->persist($candidate);
            $manager->flush();
            
            $this->addFlash('success', 'Inscription réussi !');
        }

        return $this->render('home/register.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
