<?php

namespace App\ApiController;

use App\Entity\User;
use App\Event\FilterUserRegistrationEvent;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/auth", host="api.qaam.fr")
 */
class AuthController extends AbstractFOSRestController
{

    private $eventDispatcher;

    function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Rest\Post(
     *     path="/register",
     *     name="auth_register_api"
     * )
     * @return View
     */
    public function register(Request $request, UserManagerInterface $userManager){
        $user = new User();
        $user
                ->setUsername($request->get('username'))
                ->setPlainPassword($request->get('password'))
                ->setEmail($request->get('email'))
                ->setEnabled(false)
                ->setRoles(['ROLE_USER'])
                ->setSuperAdmin(false);
        try {
            $this->eventDispatcher->dispatch('user_registration.created', new FilterUserRegistrationEvent($user, $request));
            $userManager->updateUser($user);
        } catch (\Exception $e) {
            return View::create(["error" => $e->getMessage()], 500);
        }
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get(
     *     path="/profile",
     *     name="auth_profile_api"
     * )
     * @return View
     */
    public function profile()
    {
        $user= $this->getUser();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($user, null,
            ['attributes' => [
                'id',
                'username',
                'email'
                ]
            ]);
        return View::create($object, response::HTTP_OK);
    }

}
