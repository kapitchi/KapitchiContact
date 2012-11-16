<?php
namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface;
use KapitchiApp\PluginManager\AbstractPlugin;
        
/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactTypeCompany extends AbstractPlugin
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
        $sharedEm = $em->getSharedManager();
        
        $instance = $this;
        
        $sharedEm->attach('KapitchiContact\Form\Contact', 'init', function($e) use ($sm, $instance) {
            $form = $e->getTarget();
            $typeHandleEl = $form->get('typeHandle');
            $opts = $typeHandleEl->getValueOptions();
            $opts[] = array(
                'label' => $instance->translate('Company'),
                'value' => 'company',
            );
            $typeHandleEl->setValueOptions($opts);
            
            $form->add($sm->get('KapitchiContact\Form\Company'), array(
                'name' => 'company'
            ));
        });
        
        $sharedEm->attach('KapitchiContact\Form\Contact', 'setData', function($e) use ($sm) {
            $form = $e->getTarget();
            $data = $e->getParam('data');
            
            if(empty($data['company'])) {
                $id = $form->get('id')->getValue();
                $pluginService = $sm->get('KapitchiContact\Service\Company');
                $entity = $pluginService->findOneBy(array(
                    'contactId' => $id
                ));
                if($entity) {
                    $companyForm = $form->get('company');
                    $companyForm->setData($pluginService->createArrayFromEntity($entity));
                }
            }
        });
        
        $sharedEm->attach('KapitchiContact\Form\ContactInputFilter', 'isValid.pre', function($e) use ($sm) {
            $ins = $e->getTarget();
            if($ins->getRawValue('typeHandle') != 'company') {
                $group = $ins->getValidationGroup();
                if(($key = array_search('company', $group)) !== false) {
                    unset($group[$key]);
                    $ins->setValidationGroup($group);
                }
            }
        });
        
        $sharedEm->attach('KapitchiContact\Form\ContactInputFilter', 'init', function($e) use ($sm) {
            $ins = $e->getTarget();
            $ins->add($sm->get('KapitchiContact\Form\CompanyInputFilter'), 'company');
        });
        
        
        $sharedEm->attach('KapitchiContact\Service\Contact', 'persist', function($e) use ($sm) {
            $data = $e->getParam('data');
            if(isset($data['company'])) {
                $companyService = $sm->get('KapitchiContact\Service\Company');
                $company = $companyService->createEntityFromArray($data['company']);
                $company->setContactId($e->getParam('entity')->getId());
                $companyService->persist($company, $data['company']);
            }
        });
        
        $sharedEm->attach('KapitchiContact\Service\Contact', 'getFieldValues', function($e) use ($sm, $instance) {
            $contactService = $e->getTarget();
            $entity = $e->getParam('entity');
            if($entity->getTypeHandle() == 'company') {
                $ret = array(
                    'typeLabel' => $instance->translate('Company')
                );
                
                $company = $sm->get('KapitchiContact\Service\Company')->getOneBy(array('contactId' => $entity->getId()));
                if($company->getPrimaryContactId()) {
                    $individual = $contactService->get($company->getPrimaryContactId());
                    $ret['primaryContactDisplayName'] = $individual->getDisplayName();
                    $ret['primaryEmail'] = $contactService->getFieldValues($individual, 'primaryEmail');
                    $ret['primaryPhone'] = $contactService->getFieldValues($individual, 'primaryPhone');
                }
                return $ret;
            }
        });
        
    }
}