<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/plugins/gantry5/engines/nucleus/particles/loginform.yaml',
    'modified' => 1465381214,
    'data' => [
        'name' => 'Login Form',
        'description' => 'Display Login Form.',
        'type' => 'particle',
        'icon' => 'fa-user',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Globally enable Login Form particle.',
                    'default' => true
                ],
                'class' => [
                    'type' => 'input.selectize',
                    'label' => 'CSS Classes',
                    'description' => 'CSS class name for the form.'
                ],
                'title' => [
                    'type' => 'input.text',
                    'label' => 'Title',
                    'description' => 'Customize the title text.',
                    'default' => 'Login'
                ],
                'greeting' => [
                    'type' => 'input.text',
                    'label' => 'Greeting',
                    'description' => 'Customize the text to be displayed as an user greeting.',
                    'default' => 'Hi, %s'
                ],
                'pretext' => [
                    'type' => 'input.text',
                    'label' => 'Pre Text',
                    'description' => 'Customize the text to be displayed before the login form.'
                ],
                'posttext' => [
                    'type' => 'input.text',
                    'label' => 'Post Text',
                    'description' => 'Customize the text to be displayed after the login form.'
                ]
            ]
        ]
    ]
];
