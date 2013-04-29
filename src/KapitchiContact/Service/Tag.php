<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Service;

use KapitchiEntity\Service\EntityService;

class Tag extends EntityService
{
    public function addContactTagByHandle($contactId, $tagHandle)
    {
        $tag = $this->getOneBy(array('handle' => $tagHandle));
        $this->getMapper()->addContactTag($contactId, $tag->getId());
    }
}