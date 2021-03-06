<?php



namespace App\ApiController;

use App\Repository\StatusRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/status", host="api.qaam.fr")
 */
class StatusController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/",
     * name="status_list_api",
     * )
     * @Rest\View()
     */
    public function index(StatusRepository $statusrepository): View
    {
        $status = $statusrepository->findAll();
        $status = $this->normalize($status);
        return View::create($status,Response::HTTP_OK);
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
            ]]);
        return $object;
    }
}
