<?php

namespace WNC\SoldierBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WNC\SoldierBundle\Entity\Participant;
use WNC\SoldierBundle\Form\ParticipantType;

/**
 * Participant controller.
 *
 * @Route("/participant")
 */
class ParticipantController extends Controller
{
    /**
     * Lists all Participant entities.
     *
     * @Route("/", name="participant")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WNCSoldierBundle:Participant')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Participant entity.
     *
     * @Route("/{id}/show", name="participant_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WNCSoldierBundle:Participant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Soldier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            
        );
    }

    /**
     * Displays a form to create a new Participant entity.
     *
     * @Route("/new", name="participant_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Participant();
        $form   = $this->createForm(new ParticipantType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Participant entity.
     *
     * @Route("/create", name="participant_create")
     * @Method("POST")
     * @Template("WNCSoldierBundle:Participant:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Participant();
        $form = $this->createForm(new ParticipantType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('participant_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Participant entity.
     *
     * @Route("/{id}/edit", name="participant_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WNCSoldierBundle:Participant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Participant entity.');
        }

        $editForm = $this->createForm(new ParticipantType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Participant entity.
     *
     * @Route("/{id}/update", name="participant_update")
     * @Method("POST")
     * @Template("WNCSoldierBundle:Participant:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WNCSoldierBundle:Participant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Participant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ParticipantType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('participant_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Participant entity.
     *
     * @Route("/{id}/delete", name="participant_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WNCSoldierBundle:Participant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Participant entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('participant'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
