<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/6/2017
 * Time: 11:07 PM
 */

namespace AppBundle\Listener;

use AppBundle\Entity\FieldValue;
use AppBundle\Helper\FileUploader;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FormSubscriber implements EventSubscriberInterface
{
    protected $formName;
    protected $entityManager;
    protected $extendedForm;
    protected $fileUploader;

    public function __construct(EntityManager $entityManager,FileUploader $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader=$fileUploader;

    }

    public function setFormName($formName = null)
    {
        $this->formName = $formName;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.post_set_data
        // event and that the postSetData method should be called.
        return array(FormEvents::POST_SET_DATA => 'postSetData',
            FormEvents::POST_SUBMIT => 'postSubmit');
    }

    public function postSetData(FormEvent $event)
    {
        $data_class = $event->getData();
        $form = $event->getForm();

        //here will be entity manager that takes ExtendedForm from DB by form name
        //form will have fieldTypes and foreach fieldType we will use builder->add...
        //if form will have data_class then to every fieldType we should get fieldValues by data_class->id, and
        // for every build->add we should set value that we will take from DB from table fieldValue->getFiledType()->getType();
        // getValue
        // preSubmitevent :set values->setId() = fieldValue->getId() and save || Or Update values

        /** if  $form  is not reportType form then get name of the form*/
        if (!$this->formName)
            $this->formName = $form->getName();

        $this->extendedForm = $this->entityManager->getRepository('AppBundle:ExtendedForm')->findOneBy(['name' => $this->formName]);
        /**if form is extended then show other fields*/
        if ($this->extendedForm) {

//            $form->add('a',null,['mapped'=>false,]);

            $fields = $this->extendedForm->getFieldTypes();
            if ($data_class->getId()) {
                $fieldValues = $this->entityManager->getRepository('AppBundle:FieldValue')->findBy(['dataclassId' => $data_class->getId(),
                    'dataclassName' => $form->getName()]);

                /**if $fieldValues array is not empty*/
                if (count($fieldValues)) {

//                    $form->add('yes',null,['mapped'=>false]);

                    foreach ($fieldValues as $fieldValue) {
                        $fieldType = $fieldValue->getFieldType();
                        $value = $fieldValue->getValue();

                  /**if $value is datetype*/
                        if (strpos($fieldType->getType(), 'DateType')) {
                            $value = new \DateTime($value);
                        }
                  /**if $value is fileType*/

                        if (strpos($fieldType->getType(), 'File')) {
//                           create file
                            $value = new UploadedFile($this->fileUploader->getTargetDir().'/'.$value,$value);

                            $form->add($fieldType->getId().'file',null, [
                                'mapped' => false,
                                'label' => 'Uploaded file',
                                'disabled'=>true,
                                'data' => $value->getBasename(),
                            ]);
                        }
                        $form->add($fieldType->getId(), $fieldType->getType(), [
                            'mapped' => false,
                            'label' => $fieldType->getName(),
                            'data' => $value,
                            'required'=>false,

                        ]);
                    }
                }
            } else {
                if (count($fields)) {
                    foreach ($fields as $field) {
                        $form->add($field->getId(), $field->getType(), [
                            'mapped' => false,
                            'label' => $field->getName(),
                        ]);
                    }
                }
            }
        }
    }

    public function postSubmit(FormEvent $event)
    {
        $data_class = $event->getData();
        $form = $event->getForm();
        /**if form is extended then save to db*/

        if ($this->extendedForm) {

            if ($form->isValid()) {
                $this->entityManager->persist($data_class);
                $fieldTypes = $this->extendedForm->getFieldTypes();
                if (count($fieldTypes)) {
/**       if data_class does not exist then flush it to have access to data_class->getId()*/
                    if (!$data_class->getId()) {
                        $this->entityManager->persist($data_class);
                        $this->entityManager->flush($data_class);
                    }
                    foreach ($fieldTypes as $fieldType) {
                        $fieldValue = new FieldValue();
                        $fieldValue->setFieldType($fieldType);
                        $fieldValue->setDataclassId($data_class->getId());
                        $fieldValue->setDataclassName($form->getName());

                        $value = $form[$fieldType->getId()]->getData();
                        /**if value is date then format it to string*/
                        if (strpos($fieldType->getType(), 'DateType')) {
                            $value = $value->format('Y-m-d');
                        }
                        /**if value is file*/
                        if (strpos($fieldType->getType(), 'File')) {
                            $fileName = $this->fileUploader->upload($value);
                            $value=$fileName;
                        }

                        $fieldValue->setValue($value);
                        $this->entityManager->persist($fieldValue);
                    }
                    $this->entityManager->flush();
                }
            }
        }
    }
}