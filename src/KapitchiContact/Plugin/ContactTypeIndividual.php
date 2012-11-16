<?php
namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;
/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactTypeIndividual implements PluginInterface
{
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return "Adds 'individual' contact type.";
    }

    public function getName()
    {
        return '[KapitchiContact] Individual contact type';
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
        
        $sharedEm->attach('KapitchiContact\Form\Contact', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $typeHandleEl = $form->get('typeHandle');
            $opts = $typeHandleEl->getValueOptions();
            $opts[] = array(
                'label' => 'Individual',
                'value' => 'individual',
            );
            $typeHandleEl->setValueOptions($opts);
            
            $form->add($sm->get('KapitchiContact\Form\Individual'), array(
                'name' => 'individual'
            ));
        });
        
        $sharedEm->attach('KapitchiContact\Form\Contact', 'setData', function($e) use ($sm) {
            $form = $e->getTarget();
            $data = $e->getParam('data');
            
            if(empty($data['individual'])) {
                $id = $form->get('id')->getValue();
                $pluginService = $sm->get('KapitchiContact\Service\Individual');
                $entity = $pluginService->findOneBy(array(
                    'contactId' => $id
                ));
                if($entity) {
                    $pluginForm = $form->get('individual');
                    $pluginForm->setData($pluginService->createArrayFromEntity($entity));
                }
            }
        });
        
        $sharedEm->attach('KapitchiContact\Form\ContactInputFilter', 'init', function($e) use ($sm) {
            $ins = $e->getTarget();
            $ins->add($sm->get('KapitchiContact\Form\IndividualInputFilter'), 'individual');
        });
        
        $sharedEm->attach('KapitchiContact\Form\ContactInputFilter', 'isValid.pre', function($e) use ($sm) {
            $ins = $e->getTarget();
            if($ins->getRawValue('typeHandle') != 'individual') {
                $group = $ins->getValidationGroup();
                if(($key = array_search('individual', $group)) !== false) {
                    unset($group[$key]);
                    $ins->setValidationGroup($group);
                }
            }
        });
        
        $sharedEm->attach('KapitchiContact\Service\Contact', 'persist', function($e) use ($sm) {
            $data = $e->getParam('data');
            if(isset($data['individual'])) {
                $companyService = $sm->get('KapitchiContact\Service\Individual');
                $company = $companyService->createEntityFromArray($data['individual']);
                $company->setContactId($e->getParam('entity')->getId());
                $companyService->persist($company, $data['individual']);
            }
        });
        
    }
}