<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact;

use Zend\ModuleManager\Feature\ControllerProviderInterface,
    Zend\EventManager\EventInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface,
    KapitchiBase\ModuleManager\AbstractModule,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions,
    KapitchiEntity\Mapper\EntityDbAdapterMapper;

class Module extends AbstractModule implements
    ControllerProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        
        
    }
    
    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                //'KapitchiIdentity\Controller\Identity' => 'KapitchiIdentity\Controller\IdentityController',
            ),
            'factories' => array(
                'KapitchiContact\Controller\Contact' => function($sm) {
                    $cont = new Controller\ContactController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapitchiContact\Service\Contact'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapitchiContact\Form\Contact'));
                    return $cont;
                },
                //API
                'KapitchiContact\Controller\Api\Contact' => function($sm) {
                    $cont = new Controller\Api\ContactRestfulController(
                        $sm->getServiceLocator()->get('KapitchiContact\Service\Contact')
                    );
                    return $cont;
                },
            )
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                //'KapitchiIdentity\Controller\Identity' => 'KapitchiIdentity\Controller\IdentityController',
            ),
            'factories' => array(
                'contact' => function($sm) {
                    $ins = new View\Helper\Contact(
                        $sm->getServiceLocator()->get('KapitchiContact\Service\Contact')
                    );
                    return $ins;
                },
            )
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'KapitchiContact\Mapper\Storage' => 'KapitchiContact\Mapper\StorageDbAdapter'
            ),
            'invokables' => array(
                'KapitchiContact\Entity\Contact' => 'KapitchiContact\Entity\Contact',
                'KapitchiContact\Entity\ContactAddress' => 'KapitchiContact\Entity\ContactAddress',
                'KapitchiContact\Entity\Individual' => 'KapitchiContact\Entity\Individual',
                'KapitchiContact\Entity\Company' => 'KapitchiContact\Entity\Company',
                'KapitchiContact\Entity\Storage' => 'KapitchiContact\Entity\Storage',
                'KapitchiContact\Entity\Tag' => 'KapitchiContact\Entity\Tag',
            ),
            'factories' => array(
                //Contact
                'KapitchiContact\Service\Contact' => function ($sm) {
                    $s = new Service\Contact(
                        $sm->get('KapitchiContact\Mapper\ContactDbAdapter'),
                        $sm->get('KapitchiContact\Entity\Contact'),
                        $sm->get('KapitchiContact\Entity\ContactHydrator')
                    );
                    $s->setStorageService($sm->get('KapitchiContact\Service\Storage'));
                    $s->setTagService($sm->get('KapitchiContact\Service\Tag'));
                    return $s;
                },
                'KapitchiContact\Mapper\ContactDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        $sm->get('KapitchiContact\Entity\Contact'),
                        $sm->get('KapitchiContact\Entity\ContactHydrator'),
                       'contact'
                    );
                },
                'KapitchiContact\Entity\ContactHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiContact\Form\Contact' => function ($sm) {
                    $ins = new Form\Contact('contact');
                    $ins->setInputFilter($sm->get('KapitchiContact\Form\ContactInputFilter'));
                    return $ins;
                },
                'KapitchiContact\Form\ContactInputFilter' => function ($sm) {
                    $ins = new Form\ContactInputFilter();
                    return $ins;
                },
                
                //Individual      
                'KapitchiContact\Service\Individual' => function ($sm) {
                    $s = new Service\Individual(
                        $sm->get('KapitchiContact\Mapper\IndividualDbAdapter'),
                        $sm->get('KapitchiContact\Entity\Individual'),
                        $sm->get('KapitchiContact\Entity\IndividualHydrator')
                    );
                    //$s->setInputFilter($sm->get('KapitchiContact\Entity\AuctionInputFilter'));
                    return $s;
                },
                'KapitchiContact\Mapper\IndividualDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        $sm->get('KapitchiContact\Entity\Individual'),
                        $sm->get('KapitchiContact\Entity\IndividualHydrator'),
                       'contact_individual'
                    );
                },
                'KapitchiContact\Entity\IndividualHydrator' => function ($sm) {
                    return new Entity\IndividualHydrator(false);
                },
                'KapitchiContact\Form\Individual' => function ($sm) {
                    $ins = new Form\Individual('individual');
                    $ins->setInputFilter($sm->get('KapitchiContact\Form\IndividualInputFilter'));
                    return $ins;
                },
                'KapitchiContact\Form\IndividualInputFilter' => function ($sm) {
                    $ins = new Form\IndividualInputFilter();
                    return $ins;
                },
                //Tag
                'KapitchiContact\Service\Tag' => function ($sm) {
                    $s = new Service\Tag(
                        $sm->get('KapitchiContact\Mapper\TagDbAdapter'),
                        $sm->get('KapitchiContact\Entity\Tag'),
                        $sm->get('KapitchiContact\Entity\TagHydrator')
                    );
                    return $s;
                },
                'KapitchiContact\Mapper\TagDbAdapter' => function ($sm) {
                    return new Mapper\TagDbAdapter(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        $sm->get('KapitchiContact\Entity\Tag'),
                        $sm->get('KapitchiContact\Entity\TagHydrator'),
                        'contact_tag'
                    );
                },
                'KapitchiContact\Entity\TagHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                //Company     
                'KapitchiContact\Service\Company' => function ($sm) {
                    $s = new Service\Company(
                        $sm->get('KapitchiContact\Mapper\CompanyDbAdapter'),
                        $sm->get('KapitchiContact\Entity\Company'),
                        $sm->get('KapitchiContact\Entity\CompanyHydrator')
                    );
                    //$s->setInputFilter($sm->get('KapitchiContact\Entity\AuctionInputFilter'));
                    return $s;
                },
                'KapitchiContact\Mapper\CompanyDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        $sm->get('KapitchiContact\Entity\Company'),
                        $sm->get('KapitchiContact\Entity\CompanyHydrator'),
                        'contact_company'
                    );
                },
                'KapitchiContact\Entity\CompanyHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiContact\Form\Company' => function ($sm) {
                    $ins = new Form\Company('company');
                    $ins->setInputFilter($sm->get('KapitchiContact\Form\CompanyInputFilter'));
                    return $ins;
                },
                'KapitchiContact\Form\CompanyInputFilter' => function ($sm) {
                    $ins = new Form\CompanyInputFilter();
                    return $ins;
                },
                //ContactAddress
                'KapitchiContact\Service\ContactAddress' => function ($sm) {
                    $s = new Service\ContactAddress(
                        $sm->get('KapitchiContact\Mapper\ContactAddressDbAdapter'),
                        $sm->get('KapitchiContact\Entity\ContactAddress'),
                        $sm->get('KapitchiContact\Entity\ContactAddressHydrator')
                    );
                    return $s;
                },
                'KapitchiContact\Mapper\ContactAddressDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        $sm->get('KapitchiContact\Entity\ContactAddress'),
                        $sm->get('KapitchiContact\Entity\ContactAddressHydrator'),
                        'contact_address'
                    );
                },
                'KapitchiContact\Entity\ContactAddressHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiContact\Form\ContactAddress' => function ($sm) {
                    $ins = new Form\ContactAddress();
                    $ins->setInputFilter($sm->get('KapitchiContact\Form\ContactAddressInputFilter'));
                    return $ins;
                },
                'KapitchiContact\Form\ContactAddressInputFilter' => function ($sm) {
                    $ins = new Form\ContactAddressInputFilter();
                    return $ins;
                },
                //Storage
                'KapitchiContact\Service\Storage' => function ($sm) {
                    $s = new Service\Storage(
                        $sm->get('KapitchiContact\Mapper\Storage'),
                        $sm->get('KapitchiContact\Entity\Storage'),
                        $sm->get('KapitchiContact\Entity\StorageHydrator')
                    );
                    return $s;
                },
                'KapitchiContact\Mapper\StorageDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        $sm->get('KapitchiContact\Entity\Storage'),
                        $sm->get('KapitchiContact\Entity\StorageHydrator'),
                       'contact_storage'
                    );
                },
                'KapitchiContact\Entity\StorageHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
            )
        );
    }
    
    public function getDir() {
        return __DIR__;
    }
    
    public function getNamespace() {
        return __NAMESPACE__;
    }

}