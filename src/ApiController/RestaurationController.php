<?php



namespace App\ApiController;

use App\Repository\RestaurationRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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
        return View::create($restauration,Response::HTTP_OK);
    }
}
