<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Controller;

use KapitchiEntity\Controller\EntityController;

class ContactController extends EntityController
{
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        
        $events = $this->getEventManager();
        $instance = $this;
        
        $events->attach('create.post', function($e) {
            $form = $e->getParam('form');
            $element = $form->get('typeHandle');
            if(!$element->getValue()) {
                $options = $element->getValueOptions();
                $first = current($options);
                if($first) {
                    $element->setValue($first['value']);
                }
            }
        });
        
        $events->attach('XXXindex.post', function($e) {
            $model = $e->getParam('viewModel');
            $model->setTerminal(true);
        });
    }

}
