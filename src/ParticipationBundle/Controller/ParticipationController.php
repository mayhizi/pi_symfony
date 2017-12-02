<?php

namespace ParticipationBundle\Controller;

use ParticipationBundle\Entity\Participation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Participation controller.
 *
 */
class ParticipationController extends Controller
{
    /**
     * Lists all participation entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $randonnees = $em->getRepository('RandonneeBundle:Randonnee')->findAll();

        $participations = $em->getRepository('ParticipationBundle:Participation')->createQueryBuilder("p")
            ->join('p.randonnee', 'r')
            ->where(('p.user=:user'))
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();



        return $this->render('participation/index.html.twig', array(
            'participations' => $participations, 'randonnees' => $randonnees,
        ));
    }

    /**
     * Creates a new participation entity.
     *
     */
    public function newAction($id_randonnee)
    {
        $em = $this->getDoctrine()->getManager();
        //$id_randonnee = $request->query->get('id_randonnee');

        $randonnee = $em->getRepository('RandonneeBundle:Randonnee')->findOneBy(array("id"=>$id_randonnee));
        if ($randonnee === null) return new Response('randonnee vide : '.$id_randonnee);



        $user = $this->get('security.token_storage')->getToken()->getUser();

        $isParticipated = $em->getRepository('ParticipationBundle:Participation')
            ->findOneBy(array("user"=>$user, "randonnee"=> $randonnee));

        if($isParticipated) return new Response("deja participer");

        $participation = new Participation();
        $participation->setRandonnee($randonnee);
        $participation->setUser($user);


        $em->persist($participation);
        $em->flush();

        return $this->redirectToRoute('participation_index');
    }

    /**
     * Finds and displays a participation entity.
     *
     */
    public function showAction(Participation $participation)
    {
        $deleteForm = $this->createDeleteForm($participation);

        return $this->render('participation/show.html.twig', array(
            'participation' => $participation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing participation entity.
     *
     */
    public function editAction(Request $request, Participation $participation)
    {
        $deleteForm = $this->createDeleteForm($participation);
        $editForm = $this->createForm('ParticipationBundle\Form\ParticipationType', $participation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participation_edit', array('id' => $participation->getId()));
        }

        return $this->render('participation/edit.html.twig', array(
            'participation' => $participation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a participation entity.
     *
     */
    public function deleteAction(Request $request, Participation $participation)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ParticipationBundle:Participation')->find($participation->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preisliste entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('participation_index');
    }

    /**
     * Creates a form to delete a participation entity.
     *
     * @param Participation $participation The participation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Participation $participation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('participation_delete', array('id' => $participation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
