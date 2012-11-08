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
    public function menuAction(Request $request)
    {
      $routeName = $request->get('_route');
      
      
      $r = array(
        'split' => 3,
        'menu' => array(
            'about' => array(
                'label' => 'ABOUT',
                'hebrev' => 'ונחנא ימ',
                'route' => 'about',
                'parameters' => array(
                )
                
            ),
            'mission' => array(
                'label' => 'MISSION',
                'hebrev' => 'רטמ',
                'route' => 'mission',
                'parameters' => array(
                )
                
            ),
            'faq' => array(
                'label' => 'FAQ',
                'hebrev' => 'תוצופנ תולאש',
                'route' => 'evercode_faq_faq_faq',
                'parameters' => array(
                )
                
            ),
            'press' => array(
                'label' => 'PRESS',
                'hebrev' => 'תרושקתהמ',
                'route' => 'sonata_news_news',
                'parameters' => array()
                
            ),
            'contact' => array(
                'label' => 'CONTACT',
                'hebrev' => 'רשק רוצ',
                'route' => 'contact',
                'parameters' => array(
                   
                )
                
            ),
            'donate' => array(
                'label' => 'DONATE',
                'hebrev' => 'וישכע םורת',
                'route' => 'donate',
                'parameters' => array()
                
            ),
            'signup' => array(
                'label' => 'SIGNUP',
                'hebrev' => 'המשרה',
                'route' => 'fos_user_registration_ajax',
                'parameters' => array(),
                'class' => 'register_button'
                
            ),
            
        )
      );
      
      $i =0;
      $founded = false;
      foreach($r['menu'] as $k => $row) {
        $ro = $this->generateUrl($row['route'], $row['parameters']);
        if(strstr($ro, $request->getPathInfo()) !== false && $request->getPathInfo() != '/') {

          
          $r['split'] = $i < 4 ? 3 : 4;
          $r['menu'][$k]['width'] = 'six';
          $r['menu'][$k]['current'] = true;
          $founded = true;
        }
        else if($r['split']) {
          $r['menu'][$k]['width'] = 'three';
        }
        
        $i++;
        
      }
      
      if(!$founded) {
        $r['menu']['about']['current'] = true;
        $r['menu']['about']['width'] = 'six';
        $r['split'] = 3;
      }
      
      $i =0;
      $j= 1;
      $r['groups'] = array();
      
      foreach($r['menu'] as $k => $row) {
        
        if(isset($row['current'])) {
          
          
          $r['groups'][0] = $k;
        }
        else {
          if(!isset($r['groups'][$j])) {
            $r['groups'][$j] = array();
          }
          $r['groups'][$j][] = $k;
          
          if(count($r['groups'][$j]) == 3)
            $j++;
          
        }
        
        
        
        
      }
      
      ksort($r['groups']);
      
      return $this->render('WNCSoldierBundle:Default:_menu.html.twig', $r);
      
    }
    
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
     * @route("/mission", name="mission") 
     * @template
     */
    public function missionAction(Request $request)
    {
      
    }
    
    
    /**
     * @route("/about", name="about") 
     * @template
     */
    public function aboutAction(Request $request)
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
        
        
        
    }
    
    /**
     * @template
     */
    public function participantsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        
        $dql = "SELECT p,c,a,u,s
          FROM ApplicationSonataUserBundle:User u
          INNER JOIN u.participant p
          LEFT JOIN u.soldier s
          INNER JOIN p.city c 
          INNER JOIN p.activity a
          ORDER BY u.createdAt DESC";
        
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
