<?php

namespace App\Listener;

use App\Entity\Post;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
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
            'preRemove',
            'preUpdate'
        ];
    }
    
    public function preRemove(LifecycleEventArgs $args) {
        
        $entity = $args->getEntity();
        
        if (!$entity instanceof Post) {
            return;
        }
        
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'mainImage'));
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        
        $entity = $args->getEntity();
        
        if (!$entity instanceof Post) {
            return;
        }
        
        if ($entity->getMainImage() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'mainImage'));
        }
    }
}