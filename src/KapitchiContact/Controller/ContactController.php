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
    
    public function lookupAction()
    {
        return array(
            'iframeCallerId' => $this->getRequest()->getQuery()->get('iframeCallerId')
        );
    }
}
