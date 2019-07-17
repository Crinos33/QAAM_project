<?php



namespace App\ApiController;

use App\Repository\RestaurationRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/restauration", host="api.qaam.fr")
 */
class RestaurationController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/",
     * name="restauration_list_api",
     * )
     * @Rest\View()
     */
    public function index(RestaurationRepository $restaurationrepository): View
    {
        $restauration = $restaurationrepository->findAll();
        $restauration = $this->normalize($restauration);
        return View::create($restauration,Response::HTTP_OK);
    }
    private function normalize($object)
    {
        /* Serializer, normalizer exemple */
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'name',
            ]]);
        return $object;
    }
}
