<?php


namespace WNC\SoldierBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WNC\SoldierBundle\Entity\Soldier;
use WNC\SoldierBundle\Form\SoldierType;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Soldier controller.
 *
 * @Route("/soldier")
 */
class SoldierController extends Controller
{
    /**
     * Lists all Soldier entities.
     *
     * @Route("/{maxPage}", name="soldier_page", requirements={"maxPage" = "\d+"})
     * @Template()
     */
    public function setMaxPageAction($maxPage)
    {

        $session = $this->getRequest()->getSession();
        $session->set('maxPage', $maxPage);
        
        return $this->redirect($this->generateUrl('soldier'));
        
    }
    
    /**
     * Lists all Soldier entities.
     *
     * @Route("/", name="soldier")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->getRequest()->getSession();
        
        $maxPage = $session->get('maxPage');
        
        if(!$maxPage) {
            $session->set('maxPage', 10);
            $maxPage = $session->get('maxPage');
        }
        
        
        $dql = "SELECT s,u,c FROM WNCSoldierBundle:Soldier s INNER JOIN s.user u INNER JOIN s.city c WHERE s.owner = ?1";
        
        $query = $em->createQuery($dql);
        
        $query->setParameter(1, $this->getUser()->getId());
        

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            $maxPage
        );

        return compact(array('pagination', 'maxPage'));

        
    }

    /**
     * Finds and displays a Soldier entity.
     *
     * @Route("/{id}/show", name="soldier_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WNCSoldierBundle:Soldier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Soldier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'map' => array(
                'First Name' => $entity->getUser()->getFirstname(),
                'Last Name' => $entity->getUser()->getLastname(),
                'Email Address' => $entity->getUser()->getEmail(),
                'City' => $entity->getCity()->getName(),
                'Mothers Name' => $entity->getMothersName(),
                'Service End Date' => $entity->getServiceEndDate()->format('Y-m-d'),
                'Army Unit' => $entity->getArmyUnit(),
                'Male/Female' => $entity->getGenderValue(),
                'Picture' => $entity->getPictureTag(),
                'Self description' => $entity->getSelfDescription(),
                'Video' => $entity->getVideo(),
                Soldier::getLabel('wants_to_contact') => $entity->getWantsToContactValue(),
                'Comments' => $entity->getComments()
            )
        );
    }

    /**
     * Displays a form to create a new Soldier entity.
     *
     * @Route("/new", name="soldier_new")
     * @Template()
     */
    public function newAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = new Soldier();
        $form   = $this->createForm(new SoldierType($user), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Soldier entity.
     *
     * @Route("/create", name="soldier_create")
     * @Method("POST")
     * @Template("WNCSoldierBundle:Soldier:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Soldier();
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $form = $this->createForm(new SoldierType($user->getId()), $entity);
        $form->bind($request);


        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Soldier entity.
     *
     * @Route("/{id}/edit", name="soldier_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WNCSoldierBundle:Soldier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Soldier entity.');
        }

        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $editForm = $this->createForm(new SoldierType($user->getId()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Soldier entity.
     *
     * @Route("/{id}/update", name="soldier_update")
     * @Method("POST")
     * @Template("WNCSoldierBundle:Soldier:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WNCSoldierBundle:Soldier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Soldier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SoldierType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('message',"Soldier was updated !");
            return $this->redirect($this->generateUrl('soldier_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Soldier entity.
     *
     * @Route("/{id}/delete", name="soldier_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WNCSoldierBundle:Soldier')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Soldier entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('soldier'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
