<?php



namespace App\ApiController;

use App\Repository\DeliveryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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
        return View::create($delivery,Response::HTTP_OK);
    }
}
