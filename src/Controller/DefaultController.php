<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;



class DefaultController extends AbstractController

{

    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('default/index.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR

        ]);
    }

    /**
     * @Route("/admin", name="homeAdmin")
     */
    //@IsGranted("ROLE_ADMIN")                                                      Autre facon de proteger.
    public function indexAdmin()
    {
        //$this->denyAccessUnlessGranted("ROLE_ADMIN");                             Autre facon de proteger trop noob
        return $this->render('default/index.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR

        ]);
    }
}