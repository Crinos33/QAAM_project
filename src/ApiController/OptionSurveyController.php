<?php



namespace App\ApiController;

use App\Repository\OptionSurveyRepository;
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
 * @Rest\Route("/option", host="api.qaam.fr")
 */
class OptionSurveyController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/survey",
     * name="option_survey_list_api",
     * )
     * @Rest\View()
     */
    public function index(OptionSurveyRepository $optionSurveyRepository): View
    {
        $options = $optionSurveyRepository->findAll();
        $options = $this->normalize($options);
        return View::create($options,Response::HTTP_OK);
    }
    private function normalize($object)
    {
        /* Serializer, normalizer exemple */
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'name',
                'value',
                'definition',
            ]]);
        return $object;
    }
}
