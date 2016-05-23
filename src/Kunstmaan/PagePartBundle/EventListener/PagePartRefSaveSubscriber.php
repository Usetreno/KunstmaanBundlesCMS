<?php

namespace Kunstmaan\PagePartBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Kunstmaan\PagePartBundle\Entity\PagePartRef;

class PagePartRefSaveSubscriber implements EventSubscriber
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'onFlush',
            'postFlush',
        ];
    }

    /**
     * @param OnFlushEventArgs $event
     */
    public function onFlush(OnFlushEventArgs $event)
    {
        $em   = $event->getEntityManager();
        $emId = spl_object_hash($em);
        $uow  = $em->getUnitOfWork();

        $this->items[$emId] = [];

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if (!$entity instanceof PagePartRef) {
                continue;
            }

            $entity->updateRefFromEntities();

            if ($entity->needsDelayedFlush()) {
                $uow->detach($entity);
                $this->items[$emId][] = $entity;
            }
        }
    }

    /**
     * @param PostFlushEventArgs $event
     */
    public function postFlush(PostFlushEventArgs $event)
    {
        $em   = $event->getEntityManager();
        $emId = spl_object_hash($em);

        if (empty($this->items[$emId])) {
            return;
        }

        /** @var PagePartRef $item */
        foreach ($this->items[$emId] as $item) {
            $item->updateRefFromEntities();
            $em->persist($item);
        }

        unset($this->items[$emId]);
        $em->flush();
    }
}
