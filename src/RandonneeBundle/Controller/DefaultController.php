<?php

namespace RandonneeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//to serialize data on response
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $randonnees = $em->getRepository('RandonneeBundle:Randonnee')->findAll();

        return $this->render('RandonneeBundle::Default/index.html.twig', array(
            'randonnees' => $randonnees,
        ));
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $randonnee =  $em->getRepository('RandonneeBundle:Randonnee')->findOneBy(array("id"=>$id));

        return $this->render('RandonneeBundle::default/show.html.twig', array(
            'randonnee' => $randonnee
        ));
    }
    function chercherAction($term)
    {
        $em = $this->getDoctrine()->getManager(); //appeler l'ORM entity manager

        if ($term === "all") $randonnees = $em->getRepository('RandonneeBundle:Randonnee')->findAll();
        else $randonnees = $em->getRepository('RandonneeBundle:Randonnee')->createQueryBuilder('r')
            ->where('r.nom LIKE :term')
            ->orWhere('r.destination LIKE :term')
            ->orWhere('r.description LIKE :term')
            ->orWhere('r.prix LIKE :term')
            ->setParameter('term', $term)
            ->getQuery()
            ->getResult();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($randonnees, 'json');


        return new JsonResponse($jsonContent);
        //return new JsonResponse($jsonContent);
        //return $this->render('randonnee/rechercher.html.twig', array('f' => $form->createView(),'RandonneeRech' => $RandonneeRech,'randonneeAll'=>$randonneeAll));
    }
}
