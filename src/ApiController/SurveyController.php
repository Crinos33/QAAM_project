<?php



namespace App\ApiController;

use App\Entity\Survey;
use App\Repository\OptionSurveyRepository;
use App\Repository\RestaurantRepository;
use App\Repository\StatusRepository;
use App\Repository\SurveyRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $surveys = $this->normalize($surveys);
        return View::create($surveys,Response::HTTP_OK);
    }

    /**
     * @Rest\Post(
     * path = "/new",
     * name="create_survey_for_today_api",
     * )
     * @Rest\View()
     */
    public function createSurvey(Request $request,
                                 StatusRepository $statusRepository,
                                 RestaurantRepository $restaurantRepository,
                                 OptionSurveyRepository $optionSurveyRepository): View
    {
        $survey = new Survey();

        $status = $request->get('status');
        $status = $statusRepository->find($status['id']);
        $survey->setStatus($status);

        $user = $this->getUser();
        $survey->setUser($user);

        $restaurant = $request->get('restaurant');
        $restaurant = $restaurantRepository->find($restaurant['id']);
        $survey->setRestaurant($restaurant);

        $ownFood = $request->get('ownFood');
        $survey->setOwnFood($ownFood);

        $optionSurvey = $request->get('optionSurvey');
        $optionSurvey = $optionSurveyRepository->find($optionSurvey['id']);
        $survey->setOptionSurvey($optionSurvey);

        $em = $this->getDoctrine()->getManager();
        $em->persist($survey);
        $em->flush();

        return View::create($survey,Response::HTTP_OK);
    }

    private function normalize($object)
    {
        /* Serializer, normalizer exemple */
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'optionSurvey',
                'createdAt',
                'updatedAt',
            ]]);
        return $object;
    }
}
