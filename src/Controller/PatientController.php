<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PAtientType;
use App\Repository\PatientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(PatientRepository $patientRepository): Response
    {
        $patient  = $patientRepository->findAll();

        return $this->render('patient/index.html.twig', [
            'patients' => $patient,
        ]);
    }


    #[Route('/addpatient', name: 'app_addpatient')]
    public function addpatient(PatientRepository $patientRepository, ManagerRegistry $m, Request $request): Response
    {
        $em = $m->getManager();
        $patient  = new Patient();
        $form = $this->createForm(PAtientType::class, $patient);
        $form ->handleRequest($request);
        if($form ->isSubmitted() && $form -> isValid()){
            $em->persist($patient);
            $em->flush();
            return $this->redirectToRoute('app_patient');
        }
        return $this->render('patient/addpatient.html.twig', [
            'form' => $form,
        ]);
 
        
    }

    #[Route('/updatepatient/{id}', name: 'app_updatepatient')]
    public function updatepatient(PatientRepository $patientRepository, ManagerRegistry $m, Request $request,$id ): Response
    {
        $em = $m->getManager();
        $patient  = $patientRepository->find($id);
        $form = $this->createForm(PAtientType::class, $patient);
        $form ->handleRequest($request);
        if($form ->isSubmitted() && $form -> isValid()){
            $em->persist($patient);
            $em->flush();
            return $this->redirectToRoute('app_patient');
        }
        return $this->render('patient/updatepatient.html.twig', [
            'form' => $form,
           
        ]);
    }

    #[Route('/deletpatient/{id}', name: 'app_deletepatient')]
    public function deletepatient(PatientRepository $patientRepository, ManagerRegistry $m, $id): Response
    {
        $em = $m->getManager();
        $patient = $patientRepository->find($id);
        $em->remove($patient);
        return $this->redirectToRoute('app_patient');
    }
}
