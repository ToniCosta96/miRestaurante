<?php

namespace ProyectoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use ProyectoBundle\Entity\Tapas;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('ProyectoBundle:Default:index.html.twig');
    }

    /**
     * @Route("/tapas", name="tapas")
     */
    public function tapasAction()
    {
        $repository = $this->getDoctrine()->getRepository(Tapas::class);
        $tapas = $repository->findAll();
        return $this->render('ProyectoBundle:Default:tapas.html.twig', array('tapas'=>$tapas));
    }
}
