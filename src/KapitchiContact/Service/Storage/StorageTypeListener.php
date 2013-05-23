<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Service\Storage;

use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\SharedEventManagerInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class StorageTypeListener implements SharedListenerAggregateInterface, ServiceLocatorAwareInterface
{
    protected $handle;
    protected $entityServiceClass;
    protected $entityFormClass;
    protected $entityInputFilterClass;
    protected $options;
    protected $elementType;
    
    protected $serviceLocator;
    
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    
    public function __construct(ServiceLocatorInterface $serviceLocator,
            $handle,
            $entityServiceClass,
            $entityFormClass,
            $entityInputFilterClass,
            array $options,
            $elementType = 'Zend\Form\Element\Text'
    )
    {
        $this->setServiceLocator($serviceLocator);
        
        $this->handle = $handle;
        $this->entityServiceClass = $entityServiceClass;
        $this->entityFormClass = $entityFormClass;
        $this->entityInputFilterClass = $entityInputFilterClass;
        $this->options = $options;
        $this->elementType = $elementType;
    }

    /**
     * Attach listeners to an event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function attachShared(SharedEventManagerInterface $sharedEm)
    {
        $this->listeners[] = $sharedEm->attach($this->entityFormClass, 'init', array($this, 'onEntityFormInit'));
        $this->listeners[] = $sharedEm->attach($this->entityFormClass, 'setData', array($this, 'onEntityFormSetData'));
        $this->listeners[] = $sharedEm->attach($this->entityInputFilterClass, 'init', array($this, 'onEntityInputFilterInit'));
        $this->listeners[] = $sharedEm->attach($this->entityServiceClass, 'persist', array($this, 'onEntityServicePersist'));
    }

    /**
     * Detach listeners from an event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function onEntityFormInit($e)
    {
        $ins = $e->getTarget();
        $primaryOptions = array();
        $elementOptions = array();
        
        foreach ($this->options as $option) {
            $primaryOptions[] = array(
                'label' => $option['label'],
                'value' => $option['tag']
            );
        }
        
        $fieldset = new \Zend\Form\Form();
        $fieldset->add(array(
            'name' => 'primary',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $ins->translate('Primary email'),
                'value_options' => $primaryOptions
            )
        ));
        
        foreach($this->options as $option) {
            $fieldset->add(array(
                'name' => $option['tag'],
                'type' => $this->elementType,
                'options' => array(
                    'label' => $option['label']
                )
            ));
        }
        
        $ins->add($fieldset, array(
            'name' => $this->handle
        ));
    }

    public function onEntityFormSetData($e)
    {
        $data = $e->getParam('data');
        $form = $e->getTarget();
        if(empty($data['contactId'])) {
            return;
        }
        $contactId = $data['contactId'];
        
        if(empty($data[$this->handle])) {
            $service = $this->getServiceLocator()->get('KapitchiContact\Service\Storage');
            $storageData = $service->fetchData($contactId, $this->handle);
            $storageFieldset = $form->get($this->handle);
            
            $primary = null;
            $primaryMax = 0;
            $values = array();
            foreach($storageData as $tag => $dataValues) {
                if($dataValues['priority'] > $primaryMax) {
                    $primaryMax = $dataValues['priority'];
                    $primary = $tag;
                }
                
                $values[$tag] = $dataValues['value'];
            }
            
            if($primary) {
                $storageFieldset->get('primary')->setValue($primary);
            }
            $storageFieldset->setData($values);
        }
    }

    public function onEntityInputFilterInit($e)
    {
        $ins = $e->getTarget();
        $inputFilter = new \Zend\InputFilter\InputFilter();
        
        $inputFilter->add(array(
            'name' => 'primary',
            'required' => false
        ));
        
        foreach($this->options as $option) {
            $inputFilter->add(array(
                'name' => $option['tag'],
                'required' => empty($option['required']) ? false : true
            ));
        }
        
        $ins->add($inputFilter, $this->handle);
    }

    public function onEntityServicePersist($e)
    {
        $data = $e->getParam('data');
        $entity = $e->getParam('entity');

        if(isset($data[$this->handle])) {
            $thisData = $data[$this->handle];
            $storageData = array();
            $primary = false;
            
            if(!empty($thisData['primary'])) {
                $primary = $thisData['primary'];
            }
            unset($thisData['primary']);

            foreach($thisData as $tag => $email) {
                $storageData[$tag] = array(
                    'tag' => $tag,
                    'value' => $email
                );
            }
            if($primary) {
                $storageData[$primary]['priority'] = 100;
            }

            $this->getServiceLocator()
                    ->get('KapitchiContact\Service\Storage')
                    ->persistData($entity->getContactId(), $this->handle, $storageData);
        }

    }

    /**
     * 
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

}