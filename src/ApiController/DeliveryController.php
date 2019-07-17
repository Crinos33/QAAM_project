<?php



namespace App\ApiController;

use App\Repository\DeliveryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/delivery", host="api.qaam.fr")
 */
class DeliveryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/",
     * name="delivery_list_api",
     * )
     * @Rest\View()
     */
    public function index(DeliveryRepository $deliveryrepository): View
    {
        $delivery = $deliveryrepository->findAll();
        $delivery = $this->normalize($delivery);
        return View::create($delivery,Response::HTTP_OK);
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
