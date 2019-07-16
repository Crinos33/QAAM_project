<?php



namespace App\ApiController;

use App\Repository\StatusRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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
        return View::create($status,Response::HTTP_OK);
    }
}
