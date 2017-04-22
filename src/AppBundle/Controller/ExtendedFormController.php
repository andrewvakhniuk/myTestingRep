<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChoiceItem;
use AppBundle\Entity\ExtendedForm;
use AppBundle\Entity\FieldType;
use AppBundle\Form\ChoiceItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reportform controller.
 *
 */
class ExtendedFormController extends Controller
{
    /**
     * Lists all extendedForm entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $extendedForms = $em->getRepository('AppBundle:ExtendedForm')->findAll();

        return $this->render('extendedform/index.html.twig', array(
            'extendedForms' => $extendedForms,
        ));
    }

    /**
     * Creates a new extendedForm entity.
     *
     */
    public function newAction(Request $request)
    {
        $f1=new FieldType();
        $f1->setName('field1');
        $c1=new ChoiceItem();
        $c1->setName('choice1');
        $c2=new ChoiceItem();
        $c2->setName('choice2');
        $f1->addChoiceItem($c1);
        $f1->addChoiceItem($c2);

        $f2=new FieldType();
        $f2->setName('field2');
        $c3=new ChoiceItem();
        $c3->setName('choice3');
        $c4=new ChoiceItem();
        $c4->setName('choice4');
        $f2->addChoiceItem($c3);
        $f2->addChoiceItem($c4);

        $extendedForm = new ExtendedForm();
        $extendedForm->addFieldType($f1);
        $extendedForm->addFieldType($f2);

        $form = $this->createForm('AppBundle\Form\ExtendedFormType', $extendedForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($extendedForm);
            $em->flush();

            return $this->redirectToRoute('extendedform_show', array('id' => $extendedForm->getId()));
        }

        return $this->render('extendedform/new.html.twig', array(
            'extendedForm' => $extendedForm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a extendedForm entity.
     *
     */
    public function showAction(ExtendedForm $extendedForm)
    {
        $deleteForm = $this->createDeleteForm($extendedForm);

        return $this->render('extendedform/show.html.twig', array(
            'extendedForm' => $extendedForm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing extendedForm entity.
     *
     */
    public function editAction(Request $request, ExtendedForm $extendedForm)
    {
        $deleteForm = $this->createDeleteForm($extendedForm);
        $editForm = $this->createForm('AppBundle\Form\ExtendedFormType', $extendedForm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($extendedForm);

            $em->flush();

            return $this->redirectToRoute('extendedform_edit', array('id' => $extendedForm->getId()));
        }

        return $this->render('extendedform/edit.html.twig', array(
            'extendedForm' => $extendedForm,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a extendedForm entity.
     *
     */
    public function deleteAction(Request $request, ExtendedForm $extendedForm)
    {
        $form = $this->createDeleteForm($extendedForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($extendedForm);
            $em->flush($extendedForm);
        }

        return $this->redirectToRoute('extendedform_index');
    }

    /**
     * Creates a form to delete a extendedForm entity.
     *
     * @param ExtendedForm $extendedForm The extendedForm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ExtendedForm $extendedForm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extendedform_delete', array('id' => $extendedForm->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
