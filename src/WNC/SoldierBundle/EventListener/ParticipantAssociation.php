<?php

namespace WNC\SoldierBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use WNC\SoldierBundle\Entity\Participant;
use WNC\SoldierBundle\Entity\Soldier;

class ParticipantAssociation
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Participant) {
            
            $soldierRepository = $entityManager->getRepository('WNC\SoldierBundle\Entity\Soldier');


            try {
              /* @var $soldier \WNC\SoldierBundle\Entity\Soldier */
              $soldier = $rep->findMatchingSoldier($entity);

              $soldier->setParticipant($entity);
              
              $entityManager->persist($soldier);
              
            }
            catch(\Doctrine\ORM\NoResultException $e)
            {
              // @todo some way to inform admins that no soldier is available;
            }
            
            $entityManager->flush();
          
        }
    }
}