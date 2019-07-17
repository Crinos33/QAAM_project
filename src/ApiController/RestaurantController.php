<?php



namespace App\ApiController;

use App\Repository\RestaurantRepository;
use App\Repository\SurveyRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
        $restaurants = $this->normalize($restaurants);
        return View::create($restaurants,Response::HTTP_OK);
    }
    private function normalize($object)
    {
        /* Serializer, normalizer exemple */
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'name',
                'address',
                'lat',
                'lng',
                'zipcode',
                'city',
                'isArestaurant',
                'isAshop',
                'restauration',
                'delivery',
            ]]);
        return $object;
    }
}
