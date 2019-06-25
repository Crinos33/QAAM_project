<?php

namespace App\Controller;

use App\Entity\Probe;
use App\Form\ProbeType;
use App\Repository\ProbeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/probe")
 */
class ProbeController extends AbstractController
{
    /**
     * @Route("/", name="probe_index", methods={"GET"})
     */
    public function index(ProbeRepository $probeRepository): Response
    {
        return $this->render('probe/index.html.twig', [
            'probes' => $probeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="probe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $probe = new Probe();
        $form = $this->createForm(ProbeType::class, $probe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($probe);
            $entityManager->flush();

            return $this->redirectToRoute('probe_index');
        }

        return $this->render('probe/new.html.twig', [
            'probe' => $probe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="probe_show", methods={"GET"})
     */
    public function show(Probe $probe): Response
    {
        return $this->render('probe/show.html.twig', [
            'probe' => $probe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="probe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Probe $probe): Response
    {
        $form = $this->createForm(ProbeType::class, $probe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('probe_index', [
                'id' => $probe->getId(),
            ]);
        }

        return $this->render('probe/edit.html.twig', [
            'probe' => $probe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="probe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Probe $probe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$probe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($probe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('probe_index');
    }
}
