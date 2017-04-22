<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;



/**
 * Plan controller.
 *
 */
class PlanController extends Controller
{
    /**
     * Lists all plan entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//show plans only of current user
        $plans= $em->createQueryBuilder()
            ->select('plans')->from('AppBundle:Plan', 'plans')
            ->where('plans.employee = '.$this->getUser()->getId())
            ->getQuery()->getResult();

        return $this->render('plan/index.html.twig', array(
            'plans' => $plans,
        ));
    }

    /**
     * Creates a new plan entity.
     *
     */
    public function newAction(Request $request)
    {
        $institutions=$this->getDoctrine()->getManager()->getRepository("AppBundle:Institution")->findAll();
        $reports=$this->getDoctrine()->getManager()->createQueryBuilder()->select('reports')->from('AppBundle:Report', 'reports')->where('reports.plan is NULL')->getQuery()->getResult();
        $customers=$this->getDoctrine()->getManager()->getRepository("AppBundle:Customer")->findAll();

        $plan = new Plan();
        $form = $this->createForm('AppBundle\Form\PlanType', $plan,
            ['institutions'=>$institutions,'reports'=>$reports,'customers'=>$customers]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $plan->setEmployee($this->getUser());
            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_show', array('id' => $plan->getId()));
        }

        return $this->render('plan/new.html.twig', array(
            'plan' => $plan,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a plan entity.
     *
     */
    public function showAction(Plan $plan)
    {
        $securityContext = $this->get('security.authorization_checker');
//Employee can not look at other employees* plans
        if(!$securityContext->isGranted('ROLE_MANAGER')&&$plan->getEmployee()->getId()!=$this->getUser()->getId()) {
            return $this->redirectToRoute('access_denied');
        }

        $deleteForm = $this->createDeleteForm($plan);
        return $this->render('plan/show.html.twig', array(
            'plan' => $plan,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plan entity.
     *
     */
    public function editAction(Request $request, Plan $plan)
    {
        $deleteForm = $this->createDeleteForm($plan);
        $editForm = $this->createForm('AppBundle\Form\PlanType', $plan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plan_edit', array('id' => $plan->getId()));
        }

        return $this->render('plan/edit.html.twig', array(
            'plan' => $plan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plan entity.
     *
     */
    public function deleteAction(Request $request, Plan $plan)
    {
        $form = $this->createDeleteForm($plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plan);
            $em->flush($plan);
        }

        return $this->redirectToRoute('plan_index');
    }

    /**
     * Creates a form to delete a plan entity.
     *
     * @param Plan $plan The plan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plan $plan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plan_delete', array('id' => $plan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
