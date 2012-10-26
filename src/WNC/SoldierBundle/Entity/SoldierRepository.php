<?php

namespace WNC\SoldierBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * SoldierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SoldierRepository extends EntityRepository
{
  public function findMatchingSoldier(Participant $participant)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder();
        
        $q->select('s')
                ->addSelect(sprintf('MATCH(s.city = %d) AS orderColumn', $participant->getCityId()))
                ->from('WNC\SoldierBundle\Entity\Soldier', 's')
                ->orderBy('orderColumn', 'DESC')
                ->setMaxResults(1);
        
        $rs = $q->getQuery()->getOneOrNullResult();
        
        if(count($rs)) {
          return current($rs);
        }
        
    }
  
}