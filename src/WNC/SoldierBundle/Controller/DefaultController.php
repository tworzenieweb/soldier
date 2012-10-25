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
     * @route("/donate", name="donate") 
     * @template
     */
    public function donateAction(Request $request)
    {
      
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
        
        $participant = new Participant();
        $soldier = new Soldier();
        
        $form2   = $this->createForm(new \Application\Sonata\UserBundle\Form\Type\RegistrationFormType($participant));
        $form   = $this->createForm(new \Application\Sonata\UserBundle\Form\Type\RegistrationFormType($soldier));
      
        return array(
            'form'   => $form->createView(),
            'form2'   => $form2->createView(),
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
     * @route("/contact-us", name="contact") 
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
                    ->setTo($this->container->getParameter('contact_email'))
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
