<?php

namespace KapitchiContact;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    KapitchiIdentity\Form\Identity as IdentityForm,
    Zend\EventManager\EventDescription as Event;

class Module extends \KapitchiBase\Module\ModuleAbstract
{
    public function getDir() {
        return __DIR__;
    }
    
    public function getNamespace() {
        return __NAMESPACE__;
    }
}
