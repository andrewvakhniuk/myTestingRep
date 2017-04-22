<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Institution;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Institution controller.
 *
 */
class InstitutionController extends Controller
{
    /**
     * Lists all institution entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $institutions = $em->getRepository('AppBundle:Institution')->findAll();

        return $this->render('institution/index.html.twig', array(
            'institutions' => $institutions,
        ));
    }

    /**
     * Creates a new institution entity.
     *
     */
    public function newAction(Request $request)
    {
        $customers=$this->getDoctrine()->getManager()->getRepository("AppBundle:Customer")->findAll();
        $institution = new Institution();
        $form = $this->createForm('AppBundle\Form\InstitutionType', $institution,['customers'=>$customers]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($institution);
            $em->flush();

            return $this->redirectToRoute('institution_show', array('id' => $institution->getId()));
        }

        return $this->render('institution/new.html.twig', array(
            'institution' => $institution,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a institution entity.
     *
     */
    public function showAction(Institution $institution)
    {
        $deleteForm = $this->createDeleteForm($institution);

        return $this->render('institution/show.html.twig', array(
            'institution' => $institution,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing institution entity.
     *
     */
    public function editAction(Request $request, Institution $institution)
    {
        $deleteForm = $this->createDeleteForm($institution);
        $editForm = $this->createForm('AppBundle\Form\InstitutionType', $institution);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('institution_edit', array('id' => $institution->getId()));
        }

        return $this->render('institution/edit.html.twig', array(
            'institution' => $institution,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a institution entity.
     *
     */
    public function deleteAction(Request $request, Institution $institution)
    {
        $form = $this->createDeleteForm($institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($institution);
            $em->flush($institution);
        }

        return $this->redirectToRoute('institution_index');
    }

    /**
     * Creates a form to delete a institution entity.
     *
     * @param Institution $institution The institution entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Institution $institution)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('institution_delete', array('id' => $institution->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
