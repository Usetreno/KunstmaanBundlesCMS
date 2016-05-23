<?php

namespace  Kunstmaan\PagePartBundle\Helper;

use Kunstmaan\AdminBundle\Entity\EntityInterface;
use Kunstmaan\PagePartBundle\PagePartAdmin\AbstractPagePartAdminConfigurator;

/**
 * An interface for something that contains pageparts
 */
interface HasPagePartsInterface extends EntityInterface
{

    /**
     * @return AbstractPagePartAdminConfigurator[]
     */
    public function getPagePartAdminConfigurations();

}
