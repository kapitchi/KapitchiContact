<?php

namespace KapitchiContact\Controller;

use KapitchiEntity\Controller\AbstractEntityController;

class ContactController extends AbstractEntityController
{
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('kapitchi-contact/contact', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('kapitchi-contact/contact', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
    
}
