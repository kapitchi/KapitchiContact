<?php
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
        
        $em->getSharedManager()->attach('KapitchiIdentity\Service\Identity', 'persist', function($e) use ($sm) {
            
            $data = $e->getParam('data', false);
            if($data && isset($data['contact'])) {
                $service = $sm->get('KapitchiContact\Service\Contact');
                $entity = $service->createEntityFromArray($data['contact']);
                $entity->setIdentityId($e->getParam('entity')->getId());
                $service->persist($entity, $data['contact']);
            }
        });
        
        $em->getSharedManager()->attach('KapitchiIdentity\Form\Identity', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $contactForm = $sm->get('KapitchiContact\Form\Contact');
            $form->add($contactForm, array(
                'name' => 'contact'
            ));
            
            //TODO some extras - finetuning
            //$form->get('displayName')->setAttribute('readonly', true);
            //$contactForm->remove('displayName');
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
        
        $em->getSharedManager()->attach('KapitchiIdentity\Form\IdentityInputFilter', 'init', function($e) use ($sm) {
            $if = $sm->get('KapitchiContact\Form\ContactInputFilter');
            $e->getTarget()->add($if, 'contact');
        });
        
    }
    
}