<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", host="admin.qaam.fr")
 */
class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('default/index.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }

    /**
     * @Route("/redirectionTo", name="redirectTo")
     */
    public function redirection()
    {
        // TODO : twig FOS USER
        $user = $this->getUser();
        if($user->hasRole('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->redirectToRoute('to_ng');
    }

    /**
     * @Route("/admin", name="homeAdmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function indexAdmin()
    {
        //$this->denyAccessUnlessGranted("ROLE_ADMIN");                             Autre facon de proteger trop noob
        return $this->render('default/index.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR

        ]);
    }
}
