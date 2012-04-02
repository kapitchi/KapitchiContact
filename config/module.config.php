<?php
return array(
    'di' => array(
        'instance' => array(
            'KapitchiContact\Form\Contact' => array(
                'parameters' => array(
                    
                )
            ),
            'KapitchiContact\Service\Contact' => array(
                'parameters' => array(
                    'modelPrototype' => 'KapitchiContact\Model\Contact',
                    'mapper' => 'KapitchiContact\Model\Mapper\ContactDbAdapter',
                )
            ),
        ),
    ),
);
