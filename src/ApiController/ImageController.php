<?php



namespace App\ApiController;

use App\Repository\ImageRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/image", host="api.qaam.fr")
 */
class ImageController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/",
     * name="image_list_api",
     * )
     * @Rest\View()
     */
    public function index(ImageRepository $imagerepository): View
    {
        $image = $imagerepository->findAll();
        return View::create($image,Response::HTTP_OK);
    }
}
