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
        $sharedEm = $em->getSharedManager();
        
        $sharedEm->attach('KapitchiContact\Form\Contact', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $typeHandleEl = $form->get('typeHandle');
            $opts = $typeHandleEl->getValueOptions();
            $opts[] = array(
                'label' => 'Company',
                'value' => 'company',
            );
            $typeHandleEl->setValueOptions($opts);
            
            $form->add($sm->get('KapitchiContact\Form\Company'), array(
                'name' => 'company'
            ));
        });
        
        $sharedEm->attach('KapitchiContact\Element\ContactInputFilter', 'init', function($e) use ($sm) {
            $ins = $e->getTarget();
            $ins->add($sm->get('KapitchiContact\Element\CompanyInputFilter'), 'company');
        });
        
        $sharedEm->attach('KapitchiContact\Controller\ContactController', 'update.post', function($e) use ($sm) {
            $form = $e->getParam('form');
            $entity = $e->getParam('entity');
            
            $companyForm = $form->get('company');
            $companyService = $sm->get('KapitchiContact\Service\Company');
            $company = $companyService->findOneBy(array(
                'contactId' => $entity->getId()
            ));
            if($company) {
                $companyForm->setData($companyService->createArrayFromEntity($company));
            }
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
        
    }
}