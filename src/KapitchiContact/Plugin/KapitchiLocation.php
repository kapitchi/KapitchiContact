<?php
namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class KapitchiLocation implements PluginInterface
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'Adds location form to contact form.';
    }

    public function getName()
    {
        return '[KapitchiContact] Location/address to contact assignment';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $sharedEm = $em->getSharedManager();
        
        //loads address into contact form
        $sharedEm->attach('KapitchiContact\Controller\ContactController', 'update.post', function($e) use ($sm) {
            $form = $e->getParam('form');
            $entity = $e->getParam('entity');
            $contactId = $entity->getId();
            $addressForm = $form->get('addresses')->get('default');
            
            //TODO this works with one address only
            $service = $sm->get('KapitchiContact\Service\ContactAddress');
            $contactAddress = $service->findOneBy(array(
                'contactId' => $contactId
            ));
            if($contactAddress) {
                $addressService = $sm->get('KapitchiLocation\Service\Address');
                $address = $addressService->find($contactAddress->getAddressId());
                $addressData = $addressService->createArrayFromEntity($address);
                $addressData['contactAddress'] = $service->createArrayFromEntity($contactAddress);
                $addressForm->setData($addressData);
            }
        });
        
        //persist address when persisting contact data
        $sharedEm->attach('KapitchiContact\Service\Contact', 'persist', function($e) use ($sm) {
            $data = $e->getParam('data', false);
            if($data && isset($data['addresses'])) {
                $contactId = $e->getParam('entity')->getId();
                
                $addressService = $sm->get('KapitchiLocation\Service\Address');
                foreach($data['addresses'] as $addressData) {
                    $addressData['contactAddress']['contactId'] = $contactId;
                    $address = $addressService->createEntityFromArray($addressData);
                    $addresses[] = $addressService->persist($address, $addressData);
                }
                
                $e->setParam('addressEvents', $addresses);
            }
        });
        
        //adds address form into contact form
        $em->getSharedManager()->attach('KapitchiContact\Form\Contact', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            
            $addressesForm = new \Zend\Form\Form();
            $addressForm = $sm->get('KapitchiLocation\Form\Address');
            
            $addressesForm->add($addressForm, array(
                'name' => 'default'
            ));
            
            $form->add($addressesForm, array(
                'name' => 'addresses'
            ));
            
        });
        
        //adds address inputfilter to contact filter
        $em->getSharedManager()->attach('KapitchiContact\Form\ContactInputFilter', 'init', function($e) use ($sm) {
            $addressInputFilter = $sm->get('KapitchiLocation\Form\AddressInputFilter');
            
            $addressesInputFilter = new \Zend\InputFilter\InputFilter();
            $addressesInputFilter->add(clone $addressInputFilter, 'default');
            
            $e->getTarget()->add($addressesInputFilter, 'addresses');
        });
        
        //Address extension
        $em->getSharedManager()->attach('KapitchiLocation\Service\Address', 'persist', function($e) use ($sm) {
            $data = $e->getParam('data', false);
            if($data && isset($data['contactAddress'])) {
                $address = $e->getParam('entity');
                $service = $sm->get('KapitchiContact\Service\ContactAddress');
                $entity = $service->createEntityFromArray($data['contactAddress']);
                $entity->setAddressId($address->getId());
                $entity->setTypeHandle('default');
                $event = $service->persist($entity);
                $e->setParam('contactAddressEvent', $event);
            }
        });
        
        $em->getSharedManager()->attach('KapitchiLocation\Form\Address', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $contactAddressForm = $sm->get('KapitchiContact\Form\ContactAddress');
            $form->add(clone $contactAddressForm, array(
                'priority' => 100,
                'name' => 'contactAddress'
            ));
        });
        
        $em->getSharedManager()->attach('KapitchiLocation\Form\AddressInputFilter', 'init', function($e) use ($sm) {
            $addressInputFilter = $e->getTarget();
            $addressInputFilter->add($sm->get('KapitchiContact\Form\ContactAddressInputFilter'), 'contactAddress');
        });
        
        
    }
    
}