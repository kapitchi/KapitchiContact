<?php
namespace KapitchiContact;

use Zend\ModuleManager\Feature\ControllerProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface,
    KapitchiBase\ModuleManager\AbstractModule,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions,
    KapitchiEntity\Mapper\EntityDbAdapterMapper;

class Module extends AbstractModule implements
    ControllerProviderInterface, ServiceProviderInterface
{
    
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
            )
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'KapitchiContact\Entity\Contact' => 'KapitchiContact\Entity\Contact',
                'KapitchiContact\Entity\Individual' => 'KapitchiContact\Entity\Individual',
                'KapitchiContact\Entity\Company' => 'KapitchiContact\Entity\Company',
            ),
            'factories' => array(
                'KapitchiContact\ContactType\ContactTypeManager' => 'KapitchiContact\ContactType\ContactTypeManagerFactory',
                
                //Contact
                'KapitchiContact\Service\Contact' => function ($sm) {
                    $s = new Service\Contact(
                        $sm->get('KapitchiContact\Mapper\ContactDbAdapter'),
                        $sm->get('KapitchiContact\Entity\Contact'),
                        $sm->get('KapitchiContact\Entity\ContactHydrator')
                    );
                    $s->setTypeManager($sm->get('KapitchiContact\ContactType\ContactTypeManager'));
                    return $s;
                },
                'KapitchiContact\Mapper\ContactDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'contact',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiContact\Entity\ContactHydrator'),
                            'entityPrototype' => $sm->get('KapitchiContact\Entity\Contact'),
                        ))
                    );
                },
                'KapitchiContact\Entity\ContactHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiContact\Form\Contact' => function ($sm) {
                    $ins = new Form\Contact($sm->get('KapitchiContact\ContactType\ContactTypeManager'), 'contact');
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
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'contact_individual',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiContact\Entity\IndividualHydrator'),
                            'entityPrototype' => $sm->get('KapitchiContact\Entity\Individual'),
                        ))
                    );
                },
                'KapitchiContact\Entity\IndividualHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiContact\Form\Individual' => function ($sm) {
                    $ins = new Form\Individual('individual');
                    return $ins;
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
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'contact_company',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiContact\Entity\CompanyHydrator'),
                            'entityPrototype' => $sm->get('KapitchiContact\Entity\Company'),
                        ))
                    );
                },
                'KapitchiContact\Entity\CompanyHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiContact\Form\Company' => function ($sm) {
                    $ins = new Form\Company('company');
                    return $ins;
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