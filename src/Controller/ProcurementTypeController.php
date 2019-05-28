<?php

namespace App\Controller;

use App\Entity\ProcurementType;
use App\Form\ProcurementTypeType;
use App\Repository\ProcurementTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/procurement/type")
 */
class ProcurementTypeController extends AbstractController
{
    /**
     * @Route("/", name="procurement_type_index", methods={"GET"})
     */
    public function index(ProcurementTypeRepository $procurementTypeRepository): Response
    {
        return $this->render('procurement_type/index.html.twig', [
            'procurement_types' => $procurementTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="procurement_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $procurementType = new ProcurementType();
        $form = $this->createForm(ProcurementTypeType::class, $procurementType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($procurementType);
            $entityManager->flush();

            return $this->redirectToRoute('procurement_type_index');
        }

        return $this->render('procurement_type/new.html.twig', [
            'procurement_type' => $procurementType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="procurement_type_show", methods={"GET"})
     */
    public function show(ProcurementType $procurementType): Response
    {
        return $this->render('procurement_type/show.html.twig', [
            'procurement_type' => $procurementType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="procurement_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProcurementType $procurementType): Response
    {
        $form = $this->createForm(ProcurementTypeType::class, $procurementType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('procurement_type_index', [
                'id' => $procurementType->getId(),
            ]);
        }

        return $this->render('procurement_type/edit.html.twig', [
            'procurement_type' => $procurementType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="procurement_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProcurementType $procurementType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$procurementType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($procurementType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('procurement_type_index');
    }
}
