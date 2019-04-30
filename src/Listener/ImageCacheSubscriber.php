<?php

namespace App\Listener;

use App\Entity\Picture;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{

    private $cacheManager;
    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }


    public function getSubscribedEvents()
    {
        return [
            Events::preFlush,
            EVENTS::onFlush
        ];
    }

    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $uow = $entityManager->getUnitOfWork();

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof Picture) {
                $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity)
            if ($entity instanceof User) {
                $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
            }
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $uow = $entityManager->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity)
            if ($entity instanceof User or $entity instanceof Post) {
                if ($entity instanceOf User) {
                    $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
                }
                if ($entity instanceOf Post) {
                    $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'mainImage'));
                }
            }
    }

}
