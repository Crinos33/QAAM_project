<?php



namespace App\ApiController;


use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\UserRepository;
/**
 * @Route("/user", host="api.qaam.fr")
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/",
     * name="user_list_api",
     * )
     * @Rest\View()
     */
    public function index(UserManagerInterface $userManager): View
    {
        $users = $userManager->findUsers();
        $users = $this->normalize($users);
        return View::create($users,Response::HTTP_OK);
    }


    /**
     * @Rest\Get(
     * path = "/{id}",
     * name="user_show_api",
     * )
     * @Rest\View()
     */
    public function show(User $user): View
    {
        return View::create($user, Response::HTTP_OK);
    }

//    /**
//     * Edit a User
//     * @Rest\Patch(
//     *     path = "/edit/{id}",
//     *     name = "user_edit_api",
//     * )
//     * @param Request $request
//     * @Rest\View()
//     * @return View;
//     */
//    public function edit(Request $request, User $user): Response
//    {
////        $entityManager = $this->getDoctrine()->getManager();
////        $image = $user->getImage();
////        $file = $request->get('image')->get('file')->getData();
////        if ($file){
////            $fileName = $this->generateUniqueFileName().'.'. $file->guessExtension();
////            // Move the file to the directory where brochures are stored
////            try {
////                $file->move(
////                    $this->getParameter('images_directory'), $fileName
////                );
////            } catch (FileException $e) {
////                // ... handle exception if something happens during file upload
////            }
////            $this->removeFile($image->getPath());
////            $image->setPath($this->getParameter('images_directory').'/'.$fileName) ;
////            $image->setImgpath($this->getParameter('images_path').'/'.$fileName);
////            $entityManager->persist($image);
////            echo($image);
////        }
////        if (empty($image->getId()) && !$file ) {
////            $user->setImage(null);
////        }
//    }
//    private function removeFile($path)
//    {
//        if(file_exists($path))
//        {
//            unlink($path);
//        }
//    }
    /**
     * Edit a User
     * @Rest\Patch(
     *     path = "/{id}/allow",
     *     name = "user_allow_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function confirmUser(Request $request, User $user): View {
        $user->setEnabled(true);
        return View::create($user, Response::HTTP_OK);
    }
    private function normalize($object)
    {
        /* Serializer, normalizer exemple */
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'email',
                'username',
                'password',
            ]]);
        return $object;
    }
}
