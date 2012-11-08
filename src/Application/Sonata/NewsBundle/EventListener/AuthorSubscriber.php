<?php
namespace Application\Sonata\NewsBundle\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthorSubscriber
{
     protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $securityContext = $this->container->get('security.context');
        
        $user = $securityContext->getToken()->getUser();
        
        if ($entity instanceof \Application\Sonata\NewsBundle\Entity\Post) {
        
            $formatter =  $this->container->get('sonata.formatter.pool');
        
            $entity->setContent($formatter->transform($entity->getContentFormatter(), $entity->getRawContent()));
        
            if(!$entity->getAuthor())    
                $entity->setAuthor($user);
                
            
        }
    }
}
