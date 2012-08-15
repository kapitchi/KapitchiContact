<?php
return array(
    'plugin_manager' => array(
        'invokables' => array(
            'Contact/IdentityContact' => 'KapitchiContact\Plugin\IdentityContact'
        ),
    ),
    'KapitchiContact' => array(
        'contact_types' => array(
            'factories' => array(
                'individual' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $ins = new \KapitchiContact\ContactType\Individual();
                    $ins->setTypeService($sl->get('KapitchiContact\Service\Individual'));
                    $ins->setForm($sl->get('KapitchiContact\Form\Individual'));
                    return $ins;
                },
                'company' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $ins = new \KapitchiContact\ContactType\Company();
                    $ins->setTypeService($sl->get('KapitchiContact\Service\Company'));
                    $ins->setForm($sl->get('KapitchiContact\Form\Company'));
                    return $ins;
                },
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'kapitchi-contact' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/contact',
                    'defaults' => array(
                        '__NAMESPACE__' => 'KapitchiContact\Controller',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'contact' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/contact[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Contact',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
