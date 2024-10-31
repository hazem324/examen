<?php

namespace App\Controller;

use App\Entity\Cabinet;
use App\Form\CabinetsType;
use App\Form\SearchType;
use App\Repository\CabinetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CabinetController extends AbstractController
{
    #[Route('/cabinet', name: 'app_cabinet')]
    public function index(CabinetRepository $cabinetRepository, Request $request): Response
    {
        $search = $this->createForm(SearchType::class);
        $search->handleRequest($request);
        $min = $search->get('min')-> getData();
        $max = $search->get('max')-> getData();
        $cabinets = $cabinetRepository->findAll();
          
        if($search ->isSubmitted()){
            $cabinets = $cabinetRepository->filterByPatient($min, $max);
            return $this->render('cabinet/index.html.twig', [
                'cabinets' => $cabinets,
                'search'=> $search
            ]);
        }

        return $this->render('cabinet/index.html.twig', [
            'cabinets' => $cabinets,
            'search'=> $search
        ]);
    }

    #[Route('/addcabinet', name: 'app_addcabinet')]
    public function addCabinet(ManagerRegistry $m, Request $request): Response
    {
        $em = $m->getManager();
        $cabinet = new Cabinet();
        $form = $this->createForm(CabinetsType::class, $cabinet);
        $form->handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid()){
            $em ->persist($cabinet);
            $em ->flush();
              return $this->redirectToRoute('app_cabinet');
        }
        return $this->render('cabinet/addCabinet.html.twig', [
            'controller_name' => 'CabinetController',
            'form' => $form
        ]);
    }

    #[Route('/updatecabinet/{id}', name: 'app_updatecabinet')]
    public function updateCabinet(ManagerRegistry $m, Request $request, $id, CabinetRepository $cabinetRepository): Response
    {
        $em = $m->getManager();
        $cabinet = $cabinetRepository->find($id);
        $form = $this->createForm(CabinetsType::class, $cabinet);
        $form->handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid()){
            $em ->persist($cabinet);
            $em ->flush();
              return $this->redirectToRoute('app_cabinet');
        }
        return $this->render('cabinet/updatecabinet.html.twig', [
            'controller_name' => 'CabinetController',
            'form' => $form
        ]);
    }

    #[Route('/deletecabinet/{id}', name: 'app_deletecabinet')]
    public function deleteCabinet(ManagerRegistry $m, $id, CabinetRepository $cabinetRepository): Response
    {
        
        $cabinet = $cabinetRepository->find($id);
        $em = $m->getManager();
         $em -> remove($cabinet);
         $em -> flush();
        return $this->redirectToRoute('app_cabinet');
    }
}
