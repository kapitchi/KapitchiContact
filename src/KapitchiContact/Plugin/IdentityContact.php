<?php
namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class IdentityContact implements PluginInterface
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
                $service->persist($entity, $data['contact']);
            }
        });
        $em->getSharedManager()->attach('KapitchiIdentity\Service\Identity', 'loadModel', function($e) use ($sm) {
            $model = $e->getParam('model');
            $id = $model->getEntity()->getId();
            $service = $sm->get('KapitchiContact/Service/Contact');
            $contact = $service->findOneBy(array(
                'identityId' => $id
            ));
            if($contact) {
                $contactModel = $service->loadModel($contact);
                $model->setExt('ContactModel', $contactModel);
            }
        });
        $em->getSharedManager()->attach('KapitchiIdentity\Form\Identity', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $contactForm = $sm->get('KapitchiContact\Form\Contact');
            //$contactForm->remove('displayName');
            $form->add($contactForm, array(
                'name' => 'contact'
            ));
        });
        $em->getSharedManager()->attach('KapitchiIdentity\Form\IdentityInputFilter', 'init', function($e) use ($sm) {
            $if = $sm->get('KapitchiContact\Form\ContactInputFilter');
            $e->getTarget()->add($if, 'contact');
        });
        
        $em->getSharedManager()->attach('KapitchiIdentity\Controller\IdentityController', 'update.post', function($e) use ($sm) {
            $form = $e->getParam('form');
            $model = $e->getParam('model');
            $viewModel = $e->getParam('viewModel');
            
            $id = $model->getEntity()->getId();
            $service = $sm->get('KapitchiContact/Service/Contact');
            $entity = $service->findOneBy(array(
                'identityId' => $id
            ));
            if($entity) {
                $contactForm = $form->get('contact');
                $extModel = $service->loadModel($entity);
                $typeEntity = $extModel->getTypeInstance();
                $data = $extModel->getType()->createArrayFromType($typeEntity);
                $typeHandle = $extModel->getEntity()->getTypeHandle();
                $typeForm = $contactForm->get($typeHandle);
                $typeForm->setData($data);
                $form->setData(array(
                    'contact' => $service->createArrayFromEntity($entity)
                ));
            }
        });
    }
    
}