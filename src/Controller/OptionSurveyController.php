<?php

namespace App\Controller;

use App\Entity\OptionSurvey;
use App\Form\OptionSurveyType;
use App\Repository\OptionSurveyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/option/survey")
 */
class OptionSurveyController extends AbstractController
{
    /**
     * @Route("/", name="option_survey_index", methods={"GET"})
     */
    public function index(OptionSurveyRepository $optionSurveyRepository): Response
    {
        return $this->render('option_survey/index.html.twig', [
            'option_surveys' => $optionSurveyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="option_survey_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $optionSurvey = new OptionSurvey();
        $form = $this->createForm(OptionSurveyType::class, $optionSurvey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($optionSurvey);
            $entityManager->flush();

            return $this->redirectToRoute('option_survey_index');
        }

        return $this->render('option_survey/new.html.twig', [
            'option_survey' => $optionSurvey,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_survey_show", methods={"GET"})
     */
    public function show(OptionSurvey $optionSurvey): Response
    {
        return $this->render('option_survey/show.html.twig', [
            'option_survey' => $optionSurvey,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="option_survey_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OptionSurvey $optionSurvey): Response
    {
        $form = $this->createForm(OptionSurveyType::class, $optionSurvey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('option_survey_index', [
                'id' => $optionSurvey->getId(),
            ]);
        }

        return $this->render('option_survey/edit.html.twig', [
            'option_survey' => $optionSurvey,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_survey_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OptionSurvey $optionSurvey): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionSurvey->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($optionSurvey);
            $entityManager->flush();
        }

        return $this->redirectToRoute('option_survey_index');
    }
}
