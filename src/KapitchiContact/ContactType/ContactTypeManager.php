<?php

namespace KapitchiContact\ContactType;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactTypeManager extends AbstractPluginManager
{
    /**
     * TODO - implement according the spec of AbstractPluginManager
     */
    public function validatePlugin($plugin)
    {
        if(!$plugin instanceof ContactTypeInterface) {
            throw new \Exception("Not PluginInterface object");
        }
        
    }
}