<?php

namespace App\ApiController;

use App\Entity\Survey;
use App\Form\SurveyType;
use App\Repository\SurveyRepository;
use App\Repository\RestaurantRepository;
use App\Repository\ProcurementRepository;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/survey", host="api.survey.do")
 */
class SurveyController extends AbstractFOSRestController
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Retrieves a collection of Survey resource
     * @Rest\Get(
     *      path = "/",
     *      name = "survey_list_api",
     * )
     * @Rest\View()
     */
    public function index(SurveyRepository $surveyRepository): View
    {
        $results = $surveyRepository->findBy(array("user" => $this->getUser()));
        $surveys = [];
        foreach ($results as $survey) {
            array_push($surveys, $this->normalize($survey));
        }
        return View::create($surveys, Response::HTTP_OK);

    }

    /**
     * Retrieves a collection of Survey resource
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "survey_show_api",
     * )
     * @Rest\View()
     */
    public function show(Survey $survey): View
    {
        return View::create($survey, Response::HTTP_OK);
    }

    /**
     * Create a Survey
     * @Rest\Post(
     *     path = "/new",
     *     name = "survey_create_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function create(Request $request, RestaurantRepository $restaurantRepository, ProcurementRepository $procurementRepository): View
    {
        $em = $this->getDoctrine()->getManager();
        $survey = new Survey();
        $survey->setOwnfood($request->get('own_food'));
        $survey->setRestaurantId($request->get('restaurant_id'));
        $survey->setCreatedAt($request->get('created_at'));
        $survey->setUpdatedAt($request->get('updated_at'));
        $restaurant = $restaurantRepository->find($request->get('restaurant_id'));
        $survey->setPriority($restaurant);
        $survey->setUser($this->getUser());



        $procurementId = $request->get('procurements');
        foreach ($procurementId as $id_procurement) {
            $rest = $procurementRepository->find($id_procurement);
            $rest->addSurvey($survey);
            $em->persist($rest);
        }

        $surveyEvent = new SurveyCreatedEvent($survey, $this->getUser());
        $this->dispatcher->dispatch('survey.created', $surveyEvent);
        $em->persist($survey);
        $em->flush();
        return View::create($survey, Response::HHTP_CREATED);
    }

    /**
     * Edit a Survey
     * @Rest\Put(
     *     path = "/edit/{id}",
     *     name = "survey_edit_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function edit(Request $request, Survey $survey, RestaurantRepository $restaurantRepository, ProcurementRepository $procurementRepository): View
    {
        if ($survey) {
            $em = $this->getDoctrine()->getManager();
            $survey->setOwnfood($request->get('own_food'));
            $survey->setOwnfood($request->get('own_food'));
            $survey->setRestaurantId($request->get('restaurant_id'));
            $survey->setCreatedAt($request->get('created_at'));
            $survey->setUpdatedAt($request->get('updated_at'));
            $restaurant = $restaurantRepository->find($request->get('restaurant'));
            $survey->setPriority($restaurant);



            $procurementId = $request->get('procurements');
            $procurements = new ArrayCollection();
            foreach ($procurementId as $id_procurement) {
                $restRequested = $procurementRepository->find($id_procurement);
                $restRequested->addSurvey($survey);
                $procurements->add($restRequested);
            }
            $survey->setProcurements($procurements);
            $survey->setUser($this->getUser());
            $em->persist($survey);
            $em->flush();
        }
        return View::create($survey, Response::HTTP_OK);
    }

    /**
     * Patch a Survey
     * @Rest\Patch(
     *     path = "/patch/{id}",
     *     name = "survey_patch_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function patch(Request $request, Survey $survey, ProcurementRepository $procurementRepository): View
    {
        if ($survey) {
            $form = $this->createForm(SurveyType::class, $survey);
            $form->submit($request->request->all(), false);
            $em = $this->getDoctrine()->getManager();
            $procurementId = $request->get('procurements');
            if (!empty($procurementId)) {
                $procurements = new ArrayCollection();
                foreach ($procurementId as $id_category) {
                    $restRequested = $procurementRepository->find($id_category);
                    $restRequested->addSurvey($survey);
                    $procurements->add($restRequested);
                }
                $survey->setProcurements($procurements);
            }
            $survey->setUser($this->getUser());
            $em->persist($survey);
            $em->flush();
        }
        return View::create($survey, Response::HTTP_OK);
    }

    /**
     * Delete a Survey
     * @Rest\Delete(
     *     path = "/delete/{id}",
     *     name = "survey_delete_api",
     * )
     * @Rest\View()
     *
     * @param Survey $survey
     * @return View;
     */
    public function delete(Survey $survey): View
    {
        if ($survey){
            $em = $this->getDoctrine()->getManager();
            $em->remove($survey);
            $em->flush();
        }
        return View::create([], Reponse::HTTP_NO_CONTENT);
    }

}


