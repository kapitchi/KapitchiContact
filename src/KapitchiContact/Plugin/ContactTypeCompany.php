<?php
namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;
/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactTypeCompany implements PluginInterface
{
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return "Adds 'company' contact type.";
    }

    public function getName()
    {
        return '[KapitchiContact] Company contact type';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $sm->get('KapitchiContact\ContactType\ContactTypeManager')->setFactory('company', function($sm) {
            $sl = $sm->getServiceLocator();
            $ins = new \KapitchiContact\ContactType\Company();
            $ins->setEntityService($sl->get('KapitchiContact\Service\Company'));
            $ins->setForm($sl->get('KapitchiContact\Form\Company'));
            return $ins;
        });
    }
}