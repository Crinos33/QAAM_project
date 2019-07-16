<?php



namespace App\ApiController;

use App\Repository\RestaurantRepository;
use App\Repository\SurveyRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/restaurant", host="api.qaam.fr")
 */
class RestaurantController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/",
     * name="restaurant_list_api",
     * )
     * @Rest\View()
     */
    public function index(RestaurantRepository $restaurantRepository): View
    {
        $restaurants = $restaurantRepository->findAll();
        return View::create($restaurants,Response::HTTP_OK);
    }
}
