<?php

namespace Application\Sonata\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Sonata\UserBundle\Entity\User;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    
  /**
   * 
   * @template
   */
  public function menuAction() {
    
    $request = $this->getRequest();
    
    $data = array(
        
        array(
            'label' => 'Preview',
            'route' => 'sonata_user_profile_show'
        ),
        array(
            'label' => 'Edit profile',
            'route' => 'sonata_user_profile_edit'
        ),
        array(
            'label' => 'Change password',
            'route' => 'fos_user_change_password'
        ),
        array(
            'label' => 'My Posts',
            'route' => 'sonata_news_my'
        ),
        
    );
    
    foreach($data as $i => $menu) {
      
      $ro = $this->generateUrl($menu['route'], array(), true);
      
      
      if($ro == $request->getUri()) {
        $data[$i]['active'] = true;
      }
    }
    
    return array('menus' => $data);
    
  }

}
