<?php
namespace KapitchiContact\ContactType;

use Zend\ServiceManager\Config as ServiceConfig,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactTypeManagerFactory implements FactoryInterface
{
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $pluginConfig = !isset($config['KapitchiContact']['contact_types']) ? array() : $config['KapitchiContact']['contact_types'];
        $pluginManager = new ContactTypeManager();
        
        $serviceConfig = new ServiceConfig($pluginConfig);
        $serviceConfig->configureServiceManager($pluginManager);
        
        return $pluginManager;
    }
}