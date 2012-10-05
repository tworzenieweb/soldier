<?php

namespace WNC\SoldierBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use WNC\SoldierBundle\Form\ContactType;

use WNC\SoldierBundle\Entity\Soldier;
use WNC\SoldierBundle\Entity\Participant;
use WNC\SoldierBundle\Form\SoldierType;
use WNC\SoldierBundle\Form\ParticipantType;

class DefaultController extends Controller
{
    
    
    public function loginAction()
    {
        
        return $this->render('WNCSoldierBundle:Default:_login.html.twig', 
                array('last_username' => '',
                      'error' => '',
                      'csrf_token' => $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate'))
                    );
        
    }
    
    /**
     * @route("/signup/{type}", name="signup") 
     */
    public function signupAction(Request $request, $type)
    {
        
        
        switch($type) {
            
            case 'soldier':
                
                $formType = new SoldierType();
                $entity = new Soldier();
                $template = 'WNCSoldierBundle:Soldier:new.html.twig';
                
                break;
            case 'participant':
                
                $formType = new ParticipantType();
                $entity = new Participant();
                $template = 'WNCSoldierBundle:Participant:new.html.twig';
                
                break;
            default:
                throw new Exception('Unsupported signup type');
            
        }
        
        
        
        $form = $this->createForm($formType, $entity);     

        if($request->isMethod('post'))
            $form->bind($request);
        
        return $this->render($template, array(
            'form' => $form->createView()
        ));
        
        
    }
    
    
    /**
     * @route("/", name="homepage") 
     * @template
     */
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $soldier = new Soldier();
        $participant = new Participant();
        $form_soldier   = $this->createForm(new SoldierType($user), $soldier);
        $form_participant   = $this->createForm(new ParticipantType(), $participant);

        
        
        return array(
            'form_soldier'   => $form_soldier->createView(),
            'form_participant'   => $form_participant->createView(),
        );
    }
    
    /**
     * @template
     */
    public function participantsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        
        $dql = "SELECT s,u,c FROM WNCSoldierBundle:Participant s INNER JOIN s.user u INNER JOIN s.city c ORDER BY u.createdAt desc";
        
        $query = $em->createQuery($dql);
        
        $query->setMaxResults(10);
        
        return array(
            'participants' => $query->getResult()
        );
    }
    
        
    /**
     * @route("/contact", name="contact") 
     * @template
     */
    public function contactAction(Request $request)
    {
        $form   = $this->createForm(new ContactType());
        
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $values = $form->getData();
                
                /* @var $message Swift_Mime_Message */
                $message = \Swift_Message::newInstance()
                    ->setSubject($values['topic'])
                    ->setFrom(array($values['email'] => $values['name']))
                    ->setReplyTo(array($values['email'] => $values['name']))
                    ->setTo('tworzenieweb@gmail.com')
                    ->setContentType("text/html")
                    ->setBody($this->renderView('WNCSoldierBundle:Default:mail.html.twig', $values));
                
                $this->get('mailer')->send($message);                
                $this->get('session')->setFlash('alert-box success',"Your message has been sent");
                
                return $this->redirect($this->generateUrl('contact'));
                
            }
        }
        
        return array('form' => $form->createView());
        
    }
}
