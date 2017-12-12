<?php

namespace ProyectoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use ProyectoBundle\Entity\Tapas;
use ProyectoBundle\Form\TapasType;

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

    /**
     * @Route("/tapa/id={id}", name="tapa_id", requirements={"id": "\d+"})
     */
    public function vehiculoAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Tapas::class);
        $tapa = $repository->find($id);
        return $this->render('ProyectoBundle:Default:tapa.html.twig',array('tapa'=>$tapa));
    }

    /**
     * @Route("/insertarTapa", name="insertar_tapa")
     */
    public function insertarTapaAction(Request $request)
    {
      $tapa = new Tapas();

      $form = $this->createForm(TapasType::class, $tapa);
      $form->handleRequest($request);

      $validator = $this->get('validator');
      $errors = $validator->validate($tapa);

      if($form->isSubmitted() && $form->isValid()){
        // $form->getData() holds the submitted values
        // but, the original `$tapa` variable has also been updated
        $tapa = $form->getData();
        // Guardar vehiculo
        $em = $this->getDoctrine()->getManager();
        $em->persist($tapa);
        $em->flush();

        return $this->redirectToRoute('tapas');
      }
      return $this->render('ProyectoBundle:Default:insertarTapa.html.twig',array('form' => $form->createView()));


      /*
      $tapa = new Tapas();

      $form = $this->createForm(TapasType::class, $tapa);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        // $form->getData() holds the submitted values
        // but, the original `$tapa` variable has also been updated
        $tapa = $form->getData();
        // Guardar vehiculo
        $em = $this->getDoctrine()->getManager();
        $em->persist($tapa);
        $em->flush();

        return $this->redirectToRoute('tapas');
      }
      return $this->render('ProyectoBundle:Default:insertarTapa.html.twig',array('form' => $form->createView()));*/
    }

    /**
     * @Route("/eliminarTapa/id={id}", name="eliminar_tapa")
     */
    public function eliminarTapaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tapa = $em->getRepository(Tapas::class)->find($id);
        if (!$tapa) {
            throw $this->createNotFoundException(
                'Ningún vehiculo coincide con la id '.$id
            );
        }
        $em->remove($tapa);
        $em->flush();

        return $this->redirectToRoute('tapas');
    }
}
