<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Applicant\Sonata\NewsBundle\Document;

use Sonata\NewsBundle\Model\CommentManager as ModelCommentManager;
use Sonata\NewsBundle\Model\CommentInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

use Sonata\DoctrineMongoDBAdminBundle\Datagrid\Pager;
use Sonata\DoctrineMongoDBAdminBundle\Datagrid\ProxyQuery;

use Sonata\NewsBundle\Document\CommentManager as BaseManager;

class CommentManager extends BaseManager
{
    
    public function updateCommentsCount(PostInterface $post = null) {
        
    }
}
