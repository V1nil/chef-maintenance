<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/themes/g5_hydrogen/blueprints/styles/base.yaml',
    'modified' => 1464365796,
    'data' => [
        'name' => 'Base Styles',
        'description' => 'Base styles for the Hydrogen theme',
        'type' => 'core',
        'form' => [
            'fields' => [
                'background' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Base Background',
                    'default' => '#ffffff'
                ],
                'text-color' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Base Text Color',
                    'default' => '#666666'
                ],
                'body-font' => [
                    'type' => 'input.fonts',
                    'label' => 'Body Font',
                    'default' => 'roboto, sans-serif'
                ],
                'heading-font' => [
                    'type' => 'input.fonts',
                    'label' => 'Heading Font',
                    'default' => 'roboto, sans-serif'
                ]
            ]
        ]
    ]
];
