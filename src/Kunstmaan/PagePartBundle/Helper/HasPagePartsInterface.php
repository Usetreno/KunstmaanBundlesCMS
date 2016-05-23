<?php

namespace  Kunstmaan\PagePartBundle\Helper;

use Kunstmaan\AdminBundle\Entity\EntityInterface;
use Kunstmaan\PagePartBundle\PagePartAdmin\PagePartAdminConfiguratorInterface;

/**
 * An interface for something that contains pageparts
 */
interface HasPagePartsInterface extends EntityInterface
{

    public function getId();

    /**
     * @return PagePartAdminConfiguratorInterface[]
     */
    public function getPagePartAdminConfigurations();

}
