<?php

namespace WNC\SoldierBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use WNC\SoldierBundle\Form\ContactType;

use WNC\SoldierBundle\Entity\Soldier;
use WNC\SoldierBundle\Entity\Participant;
use WNC\SoldierBundle\Form\SoldierType;
use WNC\SoldierBundle\Form\ParticipantType;


class DefaultController extends Controller
{
    public function menuAction(Request $request)
    {
      $menu = $this->container->getParameter('menu');

      $menu = $menu[$this->getRequest()->getLocale()];
      
      $path = $this->getRequest()->getPathInfo();
      
      $founded = isset($menu[$path]) ? true : false;
      
      $width = $founded ? floor(910 / (count($menu) + 2)) : ceil(910 / count($menu));
      
      
      if($founded) {
        $menu[$path]['active'] = true;
        $menu[$path]['width'] = 3 * $width;
      }
      
        
      
      return $this->render('WNCSoldierBundle:Default:_menu.html.twig', array(
          
          'default_width' => $width,
          'menu' => $menu
          
      ));
      
    }
    
    
    /**
     * @template
     */
    public function footerAction() {
      
      return array(
          
          'participants' => $em = $this->getDoctrine()
              ->getEntityManager()
              ->createQuery('SELECT COUNT(a) FROM WNCSoldierBundle:Participant a')
              ->getSingleScalarResult()
          
      );
      
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
     * @route("/language/{_locale}", name="change_language", requirements={"_locale" = "en|il"}) 
     */
    public function changeLanguageAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        
        return $this->redirect($this->generateUrl('homepage'));
        
    }
    
    /**
     * @route("/", name="homepage") 
     */
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        
        return $this->render('WNCSoldierBundle:Default:index.html.twig', array());
        
    }
    
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
        
    
        return $this->render('WNCSoldierBundle:Default:participants.html.twig', array(
            'participants' => $query->getResult()
        ));
    }
    
        
    /**
     * @template
     */
    public function contactAction($contentDocument)
    {
        $form   = $this->createForm(new ContactType());
        
        $request = $this->getRequest();
        
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
        
        if (!$contentDocument) {
            throw new NotFoundHttpException('Content not found');
        }
        
        return array(
            'form' => $form->createView(),
            'contentDocument' => $contentDocument
        );
        
        
        
    }
}
