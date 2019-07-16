<?php



namespace App\ApiController;

use App\Repository\SurveyRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/survey", host="api.qaam.fr")
 */
class SurveyController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/today",
     * name="survey_list_for_today_api",
     * )
     * @Rest\View()
     */
    public function index(SurveyRepository $surveyRepository): View
    {
        $surveys = $surveyRepository->findAll();
        return View::create($surveys,Response::HTTP_OK);
    }
}
