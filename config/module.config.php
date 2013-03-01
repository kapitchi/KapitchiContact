<?php
return array(
    'plugin_manager' => array(
        'invokables' => array(
            'Contact/KapitchiIdentity' => 'KapitchiContact\Plugin\KapitchiIdentity',
            'Contact/ContactTypeIndividual' => 'KapitchiContact\Plugin\ContactTypeIndividual',
            'Contact/ContactTypeCompany' => 'KapitchiContact\Plugin\ContactTypeCompany',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
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
                    'api' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/api',
                            'defaults' => array(
                                '__NAMESPACE__' => 'KapitchiContact\Controller\Api',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'contact' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/contact[/:action][/:id]',
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
        ),
    ),
);
