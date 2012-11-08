<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Application\Sonata\NewsBundle\Entity\Post;
use Application\Sonata\NewsBundle\Form\PostType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sonata\NewsBundle\Controller\PostController as BaseController;

class PostController extends BaseController
{
  
  /**
   * 
   * @param type $limit
   */
  public function latestAction($limit=1)
  {
      
    return $this->render('ApplicationSonataNewsBundle:Post:latest.html.twig', array(
        'posts' => $this->getDoctrine()->getRepository('ApplicationSonataNewsBundle:Post')->getLatest($limit)
    ));
    
    
    
  }
  /**
   * @Secure(roles="ROLE_USER")
   */
  public function deleteAction($id)
  {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationSonataNewsBundle:Post')->find($id);
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        if($entity->getAuthor() != $user)
            throw new AccessDeniedException();
        

        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();

        $this->get('session')->setFlash('success', 'Post was deleted');
        return $this->redirect($this->generateUrl('sonata_news_my'));
  }
  
  /**
   * @template("ApplicationSonataNewsBundle:Post:new.html.twig")
   * @Secure(roles="ROLE_USER")
   */
  public function editAction($id)
  {
  
        $user = $this->container->get('security.context')->getToken()->getUser();
        

  
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationSonataNewsBundle:Post')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Participant entity.');
        }
        
        if($entity->getAuthor() != $user)
            throw new AccessDeniedException();
  
        $request = $this->getRequest();
        
        $d = $request->get('sonata_post_post');
        
        $d['mediaType'] = isset($d['mediaType']) ? $d['mediaType'] : $entity->getImage()->getProviderName();
        
        
        $form   = $this->createForm(new PostType(isset($d['mediaType']) ? $d['mediaType'] : null), $entity);


        if($request->getMethod() == 'POST')
        {
        
            $form->bind($request);
            
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                
                $this->get('session')->setFlash('success', 'Post successfully added');
                return $this->redirect($this->generateUrl('sonata_news_my'));
                
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'data'   => $d,
            'route' => 'sonata_news_edit',
            'route_parameters' => array('id' => $entity->getId())
        );
  
  }
  
  /**
  * @template
  * @Secure(roles="ROLE_USER")
  */
  public function myAction()
  {
  
    $user = $this->container->get('security.context')->getToken()->getUser();
    return array(
        'posts' => $this->getDoctrine()->getRepository('ApplicationSonataNewsBundle:Post')->findBy(array(
        'author' => $user ))
    );
    
    
    
  }
  
   /**
    * @template
    * @Secure(roles="ROLE_USER")
    */
  public function newAction()
  {
        $request = $this->getRequest();
        $entity = new Post();
        
        $d = $request->get('sonata_post_post');
        
        
        $form   = $this->createForm(new PostType(isset($d['mediaType']) ? $d['mediaType'] : null), $entity);


        if($request->getMethod() == 'POST')
        {
        
            $form->bind($request);
            
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                
                $this->get('session')->setFlash('success', 'Post successfully added');
                return $this->redirect($this->generateUrl('sonata_news_my'));
                
            }
        }

        return array(
            'form'   => $form->createView(),
            'data'   => $d,
            'route' => 'sonata_news_new',
            'route_parameters' => array()
        );
  
  }
  

  public function sliderAction($limit = 10)
  {

      return $this->render('ApplicationSonataNewsBundle:Post:slider.html.twig', array(
        'posts' => $this->getDoctrine()->getRepository('ApplicationSonataNewsBundle:Post')->getLatest($limit)
        ));
    
  }
  
}
