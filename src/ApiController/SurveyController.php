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
use \DateTime;

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
    public function today(SurveyRepository $surveyRepository): View
    {
        $now = new DateTime('now');
        $search = $now->format('Y-m-d');
        $surveys = $surveyRepository->findAllForToday($search);
        $surveys = $this->normalize($surveys);
        return View::create($surveys,Response::HTTP_OK);
    }

    /**
     * @Rest\Get(
     * path = "/today/me",
     * name="survey_one_for_today_api",
     * )
     * @Rest\View()
     */
    public function myTodaySurvey(SurveyRepository $surveyRepository): View
    {
        $now = new DateTime('now');
        $search = $now->format('Y-m-d');
        $user = $this->getUser();

        $surveys = $surveyRepository->findOneForMeToday($search, $user->getId());
        $surveys = $this->normalize($surveys);
        return View::create($surveys,Response::HTTP_OK);
    }

    /**
     * @Rest\Get(
     * path = "/all/me",
     * name="survey_all_for_me_api",
     * )
     * @Rest\View()
     */
    public function AllSurveyForMe(SurveyRepository $surveyRepository): View
    {
        $user = $this->getUser();

        $surveys = $surveyRepository->findAllForMe($user->getId());
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
        if (is_null($restaurant) || empty($restaurant))
        {
            $survey->setRestaurant(null);
        }else{
            $restaurant = $restaurantRepository->find($restaurant['id']);
            $survey->setRestaurant($restaurant);
        }


        $ownFood = $request->get('ownFood');
        $survey->setOwnFood($ownFood);

        $optionSurvey = $request->get('optionSurvey');
        if (is_null($optionSurvey) || empty($optionSurvey))
        {
            $survey->setOptionSurvey(null);
        }else{
            $optionSurvey = $optionSurveyRepository->find($optionSurvey['id']);
            $survey->setOptionSurvey($optionSurvey);
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($survey);
        $em->flush();


        $survey = $this->normalize($survey);
        return View::create($survey,Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put(
     * path = "/edit",
     * name="update_survey_for_today_api",
     * )
     * @Rest\View()
     */
    public function updateSurvey(Request $request,
                                 SurveyRepository $surveyRepository,
                                 StatusRepository $statusRepository,
                                 RestaurantRepository $restaurantRepository,
                                 OptionSurveyRepository $optionSurveyRepository): View
    {
        $surveyId = $request->get('id');
        $survey = $surveyRepository->find($surveyId);

        $status = $request->get('status');
        $status = $statusRepository->find($status['id']);
        $survey->setStatus($status);


        $restaurant = $request->get('restaurant');
        if ( is_null($restaurant) || empty($restaurant))
        {
            $survey->setRestaurant(null);
        }else{
            $restaurant = $restaurantRepository->find($restaurant['id']);
            $survey->setRestaurant($restaurant);
        }

        $ownFood = $request->get('ownFood');
        $survey->setOwnFood($ownFood);

        $optionSurvey = $request->get('optionSurvey');
        if (is_null($optionSurvey) || empty($optionSurvey))
        {
            $survey->setOptionSurvey(null);
        }else{
            $optionSurvey = $optionSurveyRepository->find($optionSurvey['id']);
            $survey->setOptionSurvey($optionSurvey);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($survey);
        $em->flush();


        $survey = $this->normalize($survey);
        return View::create($survey,Response::HTTP_OK);
    }

    private function normalize($object)
    {
        /* Serializer, normalizer exemple */
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'optionSurvey' => [
                    'id',
                    'name',
                    'value',
                    'definition'
                ],
                'ownFood',
                'user' => [
                    'id',
                    'username',
                    'email'
                ],
                'restaurant'=> [
                    'id',
                    'name'
                ],
                'status' => [
                    'id',
                    'name',
                    'value'
                ],
                'createdAt',
                'updatedAt',
            ]]);
        return $object;
    }
}
