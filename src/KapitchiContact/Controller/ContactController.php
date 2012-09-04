<?php

namespace KapitchiContact\Controller;

use KapitchiEntity\Controller\AbstractEntityController;

class ContactController extends AbstractEntityController
{
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('contact/contact', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('contact/contact', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
    
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        
        $events = $this->getEventManager();
        $instance = $this;
        
        $events->attach('update.post', function($e) use ($instance) {
            $viewModel = $e->getParam('viewModel');
            $form = $viewModel->form;
            $model = $viewModel->model;
            
            $type = $model->getTypeInstance();
            $data = $model->getType()->createArrayFromType($type);
            $typeForm = $form->get($model->getEntity()->getTypeHandle());
            $typeForm->setData($data);
        });
        
    }
    
}
