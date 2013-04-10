<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class KapitchiIdentity implements PluginInterface
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'Adds contact form to identity form.';
    }

    public function getName()
    {
        return '[KapitchiContact] Contact/identity assignment';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $em->getSharedManager()->attach('KapitchiIdentity\Controller\IdentityController', array('create.pre', 'update.pre'), function($e) use ($sm) {
            $form = $e->getParam('form');
            $form->get('contact')->remove('identityId');
        });
        
        $em->getSharedManager()->attach('KapitchiIdentity\Service\Identity', 'persist', function($e) use ($sm) {
            $entity = $e->getParam('entity');
            $data = $e->getParam('data', false);
            if($data && isset($data['contact'])) {
                $service = $sm->get('KapitchiContact\Service\Contact');
                $contact = $service->createEntityFromArray($data['contact']);
                $contact->setIdentityId($e->getParam('entity')->getId());
                $x = $service->persist($contact, $data['contact']);
                $e->setParam('contactEvent', $x);
                $entity->setDisplayName($x->getParam('entity')->getDisplayName());
                $e->getTarget()->persist($entity);
            }
        });
        
        $em->getSharedManager()->attach('KapitchiIdentity\Form\Identity', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $form->remove('displayName');
            
            $contactForm = $sm->get('KapitchiContact\Form\Contact');
            $form->add($contactForm, array(
                'name' => 'contact'
            ));
        });
        
        $em->getSharedManager()->attach('KapitchiIdentity\Form\IdentityInputFilter', 'init', function($e) use ($sm) {
            $target = $e->getTarget();
            $target->remove('displayName');
            
            $if = $sm->get('KapitchiContact\Form\ContactInputFilter');
            $e->getTarget()->add($if, 'contact');
        });
        
        $em->getSharedManager()->attach('KapitchiIdentity\Form\Identity', 'setData', function($e) use ($sm) {
            $form = $e->getTarget('form');
            $data = $e->getParam('data');
            
            if(empty($data['contact'])) {
                $id = $form->get('id')->getValue();
                $service = $sm->get('KapitchiContact/Service/Contact');
                $entity = $service->findOneBy(array(
                    'identityId' => $id
                ));
                if($entity) {
                    $contactForm = $form->get('contact');
                    $contactForm->setData($service->createArrayFromEntity($entity));
                }
            }
        });
        
    }
    
}