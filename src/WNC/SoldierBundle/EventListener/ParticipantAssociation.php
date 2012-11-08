<?php

namespace WNC\SoldierBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use WNC\SoldierBundle\Entity\Participant;
use WNC\SoldierBundle\Entity\Soldier;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ParticipantAssociation
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Participant) {
            
            $soldierRepository = $entityManager->getRepository('WNC\SoldierBundle\Entity\Soldier');


            try {
              /* @var $soldier \WNC\SoldierBundle\Entity\Soldier */
              $soldier = $soldierRepository->findMatchingSoldier($entity);;
              
              $mailer = $this->container->get('mailer');
              $templating = $this->container->get('templating');
              
              if($soldier) {
                $soldier->setParticipant($entity);
                $entityManager->persist($soldier);
                
                
                $message = \Swift_Message::newInstance()
                  ->setSubject('You have been associated with participant')
                  ->setFrom('info@lshemshmira.com')
                  ->setCc($entity->getUser()->getEmail(), $entity->getUser()->getFirstname() . ' ' . $entity->getUser()->getLastname())
                  ->setTo($soldier->getUser()->getEmail(), $soldier->getUser()->getFirstname() . ' ' . $soldier->getUser()->getLastname())
                  ->setBody($templating->render('WNCSoldierBundle:Soldier:email_association.txt.twig', array('participant' => $entity, 'soldier' => $soldier)));
                $mailer->send($message);
                
              }
              
              
              
              
            }
            catch(\Doctrine\ORM\NoResultException $e)
            {
              // @todo some way to inform admins that no soldier is available;
            }
            
            $entityManager->flush();
          
        }
    }
}
