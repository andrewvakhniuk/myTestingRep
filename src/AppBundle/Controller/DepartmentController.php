<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Department;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * department controller.
 *
 */
class DepartmentController extends Controller
{
    /**
     * Lists all Department entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $departments = $em->getRepository('AppBundle:Department')->findAll();

        return $this->render('department/index.html.twig', array(
            'departments' => $departments,
        ));
    }

    /**
     * Creates a new department entity.
     *
     */
    public function newAction(Request $request)
    {
//        $output=new ConsoleOutput();

        $employees=$this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('employees')
            ->from('AppBundle:Employee', 'employees')
            ->where('employees.department is NULL')
            ->getQuery()->getResult();
        $departments=$this->getDoctrine()->getManager()->getRepository("AppBundle:Department")->findAll();

        $department = new department();
        $form = $this->createForm('AppBundle\Form\DepartmentType', $department,['employees'=>$employees,'departments'=>$departments]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($department->getEmployees() as $employee){
                $emp=$em->getRepository('AppBundle:Employee')->findOneBy(['id'=> $employee->getId()]);
                $emp->setDepartment($department);
            }
            $em->persist($department);
            $em->flush();

            return $this->redirectToRoute('department_show', array('id' => $department->getId()));
        }

        return $this->render('department/new.html.twig', array(
            'department' => $department,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Department entity.
     *
     */
    public function showAction(Department $department)
    {
        $deleteForm = $this->createDeleteForm($department);

        return $this->render('department/show.html.twig', array(
            'department' => $department,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Department entity.
     *
     */
    public function editAction(Request $request, Department $department)
    {
        //select only employee from current department and without department
        $employees=$this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('employees')
            ->from('AppBundle:Employee', 'employees')
            ->andWhere('employees.department is NULL')
            ->orWhere('employees.department = '.$department->getId())
            ->getQuery()->getResult();

        $deleteForm = $this->createDeleteForm($department);
        $editForm = $this->createForm('AppBundle\Form\DepartmentType', $department,['employees'=>$employees]);
        $editForm->handleRequest($request);
            $em=$this->getDoctrine()->getManager();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($department);
            $em->flush();

            return $this->redirectToRoute('department_edit', array('id' => $department->getId()));
        }

        return $this->render('department/edit.html.twig', array(
            'department' => $department,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Department entity.
     *
     */
    public function deleteAction(Request $request, Department $department)
    {
        $form = $this->createDeleteForm($department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($department);
            $em->flush($department);
        }

        return $this->redirectToRoute('department_index');
    }

    /**
     * Creates a form to delete a Department entity.
     *
     * @param Department $department The Department entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Department $department)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('department_delete', array('id' => $department->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
