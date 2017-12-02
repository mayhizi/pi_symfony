<?php

namespace RandonneeBundle\Controller;

use RandonneeBundle\Entity\Randonnee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use RandonneeBundle\Form\RechercherType;




/**
 * Randonnee controller.
 *
 */
class RandonneeController extends Controller
{
    /**
     * Lists all randonnee entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $randonnees = $em->getRepository('RandonneeBundle:Randonnee')->findBy(array('user' => $user));

        return $this->render('randonnee/index.html.twig', array(
            'randonnees' => $randonnees,
        ));
    }

    /**
     * Creates a new randonnee entity.
     *
     */
    public function newAction(Request $request)
    {

        $randonnee = new Randonnee();
        $form = $this->createForm('RandonneeBundle\Form\RandonneeType', $randonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->get('security.token_storage')->getToken()->getUser();
            $randonnee->setUser($user);
            $randonnee->setUpdatedAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($randonnee);
            $em->flush();

            return $this->redirectToRoute('randonnee_show', array('id' => $randonnee->getId()));
        }

        return $this->render('randonnee/new.html.twig', array(
            'randonnee' => $randonnee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a randonnee entity.
     *
     */
    public function showAction(Randonnee $randonnee)
    {
        $deleteForm = $this->createDeleteForm($randonnee);

        return $this->render('randonnee/show.html.twig', array(
            'randonnee' => $randonnee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing randonnee entity.
     *
     */
    public function editAction(Request $request, Randonnee $randonnee)
    {

        $deleteForm = $this->createDeleteForm($randonnee);
        $editForm = $this->createForm('RandonneeBundle\Form\RandonneeType', $randonnee);
        $editForm->remove('imageFile');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('randonnee_show', array('id' => $randonnee->getId()));
        }

        return $this->render('randonnee/edit.html.twig', array(
            'randonnee' => $randonnee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a randonnee entity.
     *
     */
    public function deleteAction(Request $request, Randonnee $randonnee)
    {
        $form = $this->createDeleteForm($randonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($randonnee);
            $em->flush();
        }

        return $this->redirectToRoute('randonnee_index');
    }

    /**
     * Creates a form to delete a randonnee entity.
     *
     * @param Randonnee $randonnee The randonnee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Randonnee $randonnee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('randonnee_delete', array('id' => $randonnee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * Lists all randonnee entities.
     *
     */
    public function indexrandAction()
    {
        $em = $this->getDoctrine()->getManager();

        $randonnees = $em->getRepository('RandonneeBundle:Randonnee')->findAll();

        return $this->render('RandonneeBundle::default/index.html.twig', array(
            'randonnees' => $randonnees,
        ));
    }
    /**
     * Finds and displays a randonnee entity.
     *
     */
    public function showrandAction(Randonnee $randonnee)
    {
        $deleteForm = $this->createDeleteForm($randonnee);

        return $this->render('randonnee/showrand.html.twig', array(
            'randonnee' => $randonnee,
            'delete_form' => $deleteForm->createView(),
        ));
    }


}
