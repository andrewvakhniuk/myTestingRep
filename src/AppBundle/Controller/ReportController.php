<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Report;
use AppBundle\Entity\ExtendedForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Report controller.
 *
 */
class ReportController extends Controller
{
    /**
     * Lists all report entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//show plans only of current user
        $reports= $em->createQueryBuilder()
            ->select('reports')->from('AppBundle:Report', 'reports')
            ->where('reports.employee = '.$this->getUser()->getId())
            ->getQuery()->getResult();

        return $this->render('report/index.html.twig', array(
            'reports' => $reports,
        ));
    }

    /**
     * Lists all report forms to choose one
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function chooseFormAction()
    {
        $em = $this->getDoctrine()->getManager();

        $extendedForms = $em->getRepository('AppBundle:ExtendedForm')->findAll();

        return $this->render('report/chooseForm.html.twig', array(
            'extendedForms' => $extendedForms,
        ));
    }

    /**
     * Creates a new report entity.
     *
     */
    public function newAction(Request $request, ExtendedForm $extendedForm)
    {
        $institutions=$this->getDoctrine()->getManager()->getRepository("AppBundle:Institution")->findAll();
        //plans where report_id==null
        $qb=$this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('plans')
            ->from('AppBundle:Plan', 'plans');
        $sub=$this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('reports')
            ->from('AppBundle:Report', 'reports')
            ->andWhere('reports.plan = plans.id');
        $qb->andWhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())));
        $plans=$qb->getQuery()->getResult();

        $customers=$this->getDoctrine()->getManager()->getRepository("AppBundle:Customer")->findAll();
 //***************************************************

        $fieldTypes=$extendedForm->getFieldTypes();
            //$this->getDoctrine()->getManager()->getRepository("AppBundle:ExtendedForm")->find(5)->getFieldTypes();

        $report = new Report();
        $form = $this->createForm('AppBundle\Form\ReportType', $report,
            ['institutions'=>$institutions,'plans'=>$plans,'customers'=>$customers,'fieldTypes'=>$fieldTypes]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $report->setEmployee($this->getUser());
            $em->persist($report);
            $em->flush($report);

            return $this->redirectToRoute('report_show', array('id' => $report->getId()));
        }

        return $this->render('report/new.html.twig', array(
            'report' => $report,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a report entity.
     *
     */
    public function showAction(Report $report)
    {
        $securityContext = $this->get('security.authorization_checker');
//Employee can not look at other employees* plans
        if(!$securityContext->isGranted('ROLE_MANAGER')&&$report->getEmployee()->getId()!=$this->getUser()->getId()) {
            return $this->redirectToRoute('access_denied');
        }

        $deleteForm = $this->createDeleteForm($report);
        return $this->render('report/show.html.twig', array(
            'report' => $report,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing report entity.
     *
     */
    public function editAction(Request $request, Report $report)
    {
        $deleteForm = $this->createDeleteForm($report);
        $editForm = $this->createForm('AppBundle\Form\ReportType', $report);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('report_show', array('id' => $report->getId()));
        }

        return $this->render('report/edit.html.twig', array(
            'report' => $report,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a report entity.
     *
     */
    public function deleteAction(Request $request, Report $report)
    {
        $form = $this->createDeleteForm($report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($report);
            $em->flush($report);
        }

        return $this->redirectToRoute('report_index');
    }

    /**
     * Creates a form to delete a report entity.
     *
     * @param Report $report The report entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Report $report)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('report_delete', array('id' => $report->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
