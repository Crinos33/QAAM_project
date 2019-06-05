<?php

namespace App\Controller;

use App\Entity\Procurement;
use App\Form\ProcurementType;
use App\Repository\ProcurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/procurement")
 */
class ProcurementController extends AbstractController
{
    /**
     * @Route("/", name="procurement_index", methods={"GET"})
     */
    public function index(ProcurementRepository $procurementRepository): Response
    {
        return $this->render('procurement/index.html.twig', [
            'procurements' => $procurementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="procurement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $procurement = new Procurement();
        $form = $this->createForm(ProcurementType::class, $procurement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($procurement);
            $entityManager->flush();

            return $this->redirectToRoute('procurement_index');
        }

        return $this->render('procurement/new.html.twig', [
            'procurement' => $procurement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="procurement_show", methods={"GET"})
     */
    public function show(Procurement $procurement): Response
    {
        return $this->render('procurement/show.html.twig', [
            'procurement' => $procurement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="procurement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Procurement $procurement): Response
    {
        $form = $this->createForm(ProcurementType::class, $procurement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('procurement_index', [
                'id' => $procurement->getId(),
            ]);
        }

        return $this->render('procurement/edit.html.twig', [
            'procurement' => $procurement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="procurement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Procurement $procurement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$procurement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($procurement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('procurement_index');
    }
}
